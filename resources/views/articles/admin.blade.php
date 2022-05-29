@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('admin'))}} {{ __('articles')}}
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="flex my-4">
            <form method="get" class="flex flex-col items-start">
                <label for="category" class="my-2">Categorie:</label>
                <div class="flex items-center">
                    <select name="category" id="category" class="rounded-md">
                        <option value="0">{{ __('pick_category')}}</option>
                        @foreach ($categories as $category)
                        <option {{ request()->category == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <button class="link-btn ml-4" type="submit">{{ ucfirst(__('filter'))}}</button>
                </div>
            </form>
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