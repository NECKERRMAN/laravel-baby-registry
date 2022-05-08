@extends('layouts.main')

@section('content')
<h1 class="text-center my-4">{{ ucfirst(__('pick_articles'))}}</h1>
    <div class="flex justify-center items-center my-4">
        <div class="category__select flex flex-col items-start mr-8">
            <label for="category" class="my-2">Categorie:</label>
        <select name="category" id="category" class="rounded-md">
            <option value="0">{{ __('pick_category')}}</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        </div>
        <div class="filter__select">
            <label for="filter">Filter</label>
        </div>
    </div>

    <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-4">
        @foreach ($articles as $article)
           @include('articles.article-card')
        @endforeach
    </div>
@endsection