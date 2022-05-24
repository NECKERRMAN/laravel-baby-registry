@extends('layouts.visitor')

@section('content')
    <div>
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
            <form action="{{ route('checkout')}}" method="get">
                <div class="form-group">
                    <label class="block" for="name">{{ ucfirst(__('your name'))}}</label>
                    <input type="text" name="name" id="name" placeholder="{{ ucfirst(__('E.g. Saul Goodman'))}}" required> 
                </div>
                <div class="form-group">
                    <label class="block" for="message">{{ ucfirst(__('your message'))}}</label>
                    <textarea type="text" name="message" id="message" placeholder="E.g. {{ ucfirst(__('congratulations'))}}" required></textarea>
                </div>
                <input type="hidden" name="registry_id" value="{{ $registry->id }}">
                <button type="submit" class="btn--submit">{{ ucfirst(__('pay'))}}</button>
            </form>
        </div>
        <div class="grid md:grid-cols-4 sm:grid-cols-2 lg:gird-cols-4 gap-4 my-4">
            @foreach ($articles as $article)
                @include('articles.article-card', ['check_array' => $cart_array])
            @endforeach
        </div>
    </div>
@endsection