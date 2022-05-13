@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center mb-8">
                <a class="link-btn" href="{{ url()->previous()}}"> &#8249; Back</a>
                <p class="ml-4">Let's add some articles</p>
            </div>
            <div class="flex mt-4">
                <aside class="mr-4 w-1/3">
                    <h3>{{ucfirst(__('current articles')) }}</h3>
                    @foreach ($current_articles as $curr)
                    <p>{{ $curr }}</p>
                    @endforeach 
                    <a href="#" class="link-btn">{{__('save')}}</a>
                </aside>
                <div class=" w-2/3">
                    @include('partials.articles-filter')
                    @if($errors->any())
                        <p class="mt-4 text-red-500">{{$errors->first()}}</p>
                    @endif
                    <div class="grid md:grid-cols-3 sm:grid-cols-2 lg:gird-cols-4 gap-4 mt-4">
                        @foreach ($articles as $article)
                            @include('articles.add', ['reg_id' => $registry->id ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection