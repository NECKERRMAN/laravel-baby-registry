@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center mb-8">
                <p class="text-sm">Let's add some articles</p>
            </div>
            <div class="flex mt-4">
                <aside class="mr-4 w-1/5">
                    <h3>{{ucfirst(__('current articles')) }}</h3>
                    <ul class="registry-list-added">
                        @foreach ($current_articles as $article)
                            <li>{{ $article->title }}</li>
                        @endforeach 
                    </ul>
                    <a href="{{ route('registry.overview', ['id' => $registry->id])}}" class="link-btn">{{__('overview')}}</a>
                </aside>
                <div class=" w-4/5">
                    @include('partials.articles-filter')

                    @if($errors->any())
                        <p class="mt-4 text-red-500">{{$errors->first()}}</p>
                    @endif
                    <div class="grid md:grid-cols-4 sm:grid-cols-2 lg:gird-cols-4 gap-4 mt-4">
                        @foreach ($articles as $article)
                            @include('articles.add', ['reg_id' => $registry->id, 'id_array' => $id_array ])
                        @endforeach
                    </div>
                    <div class="my-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection