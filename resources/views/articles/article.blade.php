@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="article">
            <a class="link-btn float-right" href="{{ url()->previous()}}">{{__('back')}}</a>
            <p class="article__name">{{ $article->title }}</p>
            <p class="article__category">{{ ucfirst(__('articles'))}} > {{ $category->title }}</p>
            <div class="flex">
                <div class="article__img">
                    <img src="/storage/{{ $article->img_int }}" alt="{{ $article->title }}" class="rounded">
                </div>
                <div class="article__content">
                    <p class="article__product-code">{{ $article->product_code }}</p>
                    <p class="article__price">€{{ sprintf("%.2f", $article->price) }}</p>
                    <div class="article__description">
                        <p>{{ ucfirst(__('article description')) }}:</p>
                        {{ $article->description }}
                    </div>
                    <div class="article__store">
                        <p>{{ ucfirst(__('available at')) }}:</p>
                        {{ $store->name }}
                    </div>
                    <div class="article__button">
                        <a href="{{ $article->slug }}">{{ __('product page')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection