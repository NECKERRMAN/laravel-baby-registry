@extends('layouts.registry')

@section('title')
<div class="text-center">
    <h1>{{ ucfirst(__('registry_welcome'))}}</h1>
    <h2>{{ $registry->name }}</h2>
</div>
@endsection

@section('content')
    <div class="flex flex-col items-center">
        <h2 class="mb-2 mt-8">{{ucfirst(__('registry_password'))}}</h2>
        <form action="#" method="POST" class="flex flex-col">
            @csrf
            <input type="hidden" name="reg_id" value="1">
            <input type="password" name="secret_password" id="secret_password">
            <button class="border rounded py-2 px-4 mt-2 border-green-800 text-green-800 uppercase" type="submit">Enter</button>
        </form>
    </div>
@endsection