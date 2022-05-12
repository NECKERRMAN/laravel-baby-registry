@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <h1>{{ucfirst($registry->name)}}</h1>
        <div>
            <a href="{{ url()->previous()}}">Back</a>
            <p>Let's add some articles</p>
            <div class="grid grid-cols-4 gap-4">
                @foreach ($articles as $article)
                    @include('articles.article-card')
                @endforeach
            </div>
        </div>
    </div>
@endsection