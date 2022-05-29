@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('all registries'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>{{ ucfirst(__('all registries'))}}</h1>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4">
            @foreach ($overview_reg as $registry)
                @include('admin.registry-item')
            @endforeach
        </div>
    </div>
@endsection