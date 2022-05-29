@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('admin'))}} {{ __('articles')}}
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="flex my-4">
            @include('partials.admin-filter')
        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-4 sm:grid-cols-2 gap-4">
            @foreach ($articles as $article)
                @include('articles.admin-card')
            @endforeach

        </div>
       <div class="my-4">
        {{ $articles->appends(request()->query())->links()  }}
       </div>
    </div>
@endsection