<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Request $req){
        // Get cart info
        $cart = Cart::session(1);
        $total = (string) $cart->getTotal();

        // Create new order
        $order = new Order();
        $order->name = $req->name;
        $order->remarks = 'Execute Order 66';
        $order->total = $total;
        $order->status = 'pending';

        // Save order in DB
        $order->save();

        // Webhook logic, accessible from online env
        $webhookUrl = route('webhooks.mollie');

        if(App::environment('local')) {
            $webhookUrl = 'https://3ab5-2a02-1811-ec8c-100-640f-a4f7-7676-97b3.eu.ngrok.io/webhooks/mollie';
        }

        Log::alert('Before Mollie Checkout total price is calculated');

        $total = number_format($total, 2);

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Bestelling op " . date('d-m-Y h:i'),
            "redirectUrl" => route('checkout.success'),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => $order->id,
                "order_from" => $order->name
            ],
        ]);
    
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function succes(){
        return 'Jouw bestelling is goed ontvangen';
    }
}
