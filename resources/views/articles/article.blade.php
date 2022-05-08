@extends('layouts.main')

@section('content')
    <div class="article">
        <p class="article__name">{{ $article->title }}</p>
        <p class="article__category">{{ ucfirst(__('articles'))}} > {{ $category->title }}</p>
        <div class="flex">
            <div class="article__img">
                <img src="https://www.babycompany.be/50963-large_default/trixie-puppet-world-l-strand.jpg" alt="a" class="rounded">
            </div>
            <div class="article__content">
                <p class="article__product-code">{{ $article->product_code }}</p>
                <p class="article__price">€{{ sprintf("%.2f", $article->price) }}</p>
                <div class="article__description">
                    <p>{{ ucfirst(__('product description:')) }}</p>
                    {{ $article->description }}
                </div>
                <div class="article__store">
                    <p>{{ ucfirst(__('Available at:')) }}</p>
                    {{ $store->name }}
                </div>
                <div class="article__button">
                    <a href="{{ $article->slug }}">{{ __('product page')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection