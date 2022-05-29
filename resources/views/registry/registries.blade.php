@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('all registries'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1 class="my-4">{{ucfirst(__('welcome'))}} {{ auth()->user()->name}}</h1>
        <div class="user-registries">
            <p class="mb-4">{{ ucfirst(__('new_registry'))}}</p>
            <a class="link-btn inline-block mb-4" href="{{route('registry.new')}}">{{ucfirst(__('new_registry_btn'))}}</a>
            <h2>{{ ucfirst(__('my_lists'))}}</h2>
            @if (count($registries) < 1)
            <p class="mb-4">{{ ucfirst(__('no registries yet')) }}</p>
            @else
                <div class="mb-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th width="200" class="py-3">{{ __('name')}}</th>
                                <th width="400" class="py-3">{{ __('link_ff')}}</th>
                                <th width="200" class="py-3">actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registries as $registry)
                                @include('partials.registry-item')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection