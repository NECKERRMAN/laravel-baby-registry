@extends('layouts.visitor')

@section('content')
    <div class="page-wrapper">
        <h1 class="my-4 text-center">{{ucfirst(__($registry->name))}}</h1>
        <div class="shopping_cart">
            <h3>{{ ucfirst(__('shopping cart'))}}</h3>
            <ul>
                @foreach ($cart->getContent() as $item)
                    <li>{{ $item->name . ' - € ' . $item->price }}</li>
                @endforeach
            </ul>
            <div class="shopping_cart__total">
                <p>{{ strtoupper(__('total'))}}: € {{ $cart->getTotal()}}</p>
                <form action="{{ route('visitor.clear')}}" method="post">
                    @csrf
                    <button class="py-2 px-4 rounded text-white bg-red-500" type="submit">{{ __('clear')}}</button>
                </form>
            </div>
        </div>
        <div class="grid md:grid-cols-4 sm:grid-cols-2 lg:gird-cols-4 gap-4 mt-4">
            @foreach ($articles as $article)
                @include('articles.article-card')
            @endforeach
        </div>
    </div>
@endsection