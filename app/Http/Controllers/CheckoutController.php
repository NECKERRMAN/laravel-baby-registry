<?php

namespace App\Http\Controllers;

use App\Mail\sendNewProductMail;
use App\Mail\sendOrderConfirmation;
use App\Models\Order;
use App\Models\Registry;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkout(Request $req){
        // Get cart info
        $cart = Cart::session(1);
        $total = (string) $cart->getTotal();

        // Create new order
        $order = new Order();

        // Get content
        $articles = $order->articles;
        foreach($cart->getContent() as $key => $value){
            $articles[] = $key;
        }

        $order->name = $req->name;
        $order->remarks = $req->message;
        $order->email = $req->email;
        $order->total = $total;
        $order->status = 'pending';
        $order->registry_id = $req->registry_id;
        $order->articles = $articles;

        // Update the registry with status and customer
        $this->setStatus($req->registry_id, $articles, $req->name);

        // Save order in DB
        $order->save();
        // Send email to customer
        Mail::to($req->email)->send(new sendOrderConfirmation($order));
        // Send email to registry owner
        Mail::to($this->userEmail($req->registry_id))->send(new sendNewProductMail($req->name, $req->message, $total));

        // Webhook logic, accessible from online env
        $webhookUrl = route('webhooks.mollie');

        if(App::environment('local')) {
            $webhookUrl = 'https://8730-2a02-1811-ec8c-100-a570-d7ea-670-3a0e.eu.ngrok.io/webhooks/mollie';
        }

        Log::alert('Before Mollie Checkout total price is calculated');

        $total = str_replace(',', '', number_format($total, 2));

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Bestelling op " . date('d-m-Y h:i'),
            "redirectUrl" => route('checkout.success', ['order_from' => $order->name]),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => $order->id,
                "order_from" => $order->name,
                "order_email" => $order->email
            ],
        ]);

    
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    // Return succes page
    public function succes(Request $req){
        return view('pages.succes', ['name' => $req->order_from]);
    }

    private function userEmail($registry_id){
        $registry = Registry::findOrFail($registry_id);
        $user = User::findOrFail($registry->user_id);
        return $user->email;
    }
    
    // Update the registry with status and customer
    private function setStatus($registry_id, $order, $customer){
        $registry = Registry::findOrFail($registry_id);

        $articles = $registry->articles;

        foreach($articles as $key => $value){
            if(in_array($value['id'], $order)){
                $articles[$key]['status'] = 1;
                $articles[$key]['ordered_by'] = $customer;
            }
        }

        $registry->articles = $articles;
        $registry->save();
    }
}
