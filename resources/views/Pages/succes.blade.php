@extends('layouts.visitor')

@section('content')
<div>
    <h1 class="my-4 text-center">Bedankt {{$name}}</h1>
    <p class="text-center">{{ ucfirst(__('order_received'))}}</p>
</div>
@endsection