@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('all categories'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>{{ ucfirst(__('all categories'))}}</h1>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4">
            @foreach ($categories as $category)
                @include('admin.category-item')
            @endforeach
        </div>
    </div>
@endsection