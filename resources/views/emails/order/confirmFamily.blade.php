@component('mail::message')
# {{ ucfirst(__('thanks_order'))}}

Your order with id #{{ $order->id}} has been created!

{{ucfirst(__('greetings'))}}
<br>
{{ config('app.name') }}
@endcomponent
