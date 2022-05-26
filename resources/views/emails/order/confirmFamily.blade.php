@component('mail::message')
# Introduction

Your order with id #{{ $order->id}} has been created!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
