@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>{{ucfirst(__('new_registry'))}}</h1>
        <form action="{{ route('registry.create')}}" method="post" class="user-registries--form">
            @csrf
            <div>
                <label for="registryName">
                    {{ucfirst(__('registry name'))}}
                </label>
                <input type="text" name="registryName" id="registryName" placeholder="e.g. {{ucfirst(__('example_registry_name'))}}">
            </div>
            <div>
                <label for="babyName">
                    {{ucfirst(__('baby name'))}}
                </label>
                <input type="text" name="babyName" id="babyName">
            </div>
            <div>
                <label for="birthdate">
                    {{ucfirst(__('birthdate baby'))}}
                </label>
                <input type="date" name="birthdate" id="birthdate">
            </div>
            <div>
                <label for="password_registry">
                    {{ucfirst(__('registry password'))}}
                </label>
                <div class="flex items-center">
                    <input type="password" name="password_registry" id="password_registry">
                    <i id="showPass" class="fa-solid fa-eye p-1"></i>
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            <button type="submit">{{ ucfirst(__('save'))}}</button>
        </form>
    </div>
@endsection