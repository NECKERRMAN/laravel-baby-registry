@component('mail::message')
# {{ ucfirst(__('thanks_order'))}}

{{ ucfirst(__('order_with_id'))}} {{ $order->id}} {{ __('been_created')}}
{{ucfirst(__('greetings'))}}
<br>
{{ config('app.name') }}
@endcomponent
