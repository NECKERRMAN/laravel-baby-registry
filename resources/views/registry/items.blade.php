@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('all articles'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center mb-8">
                <p class="text-sm">{{ ucfirst(__('add_article_subtitle'))}}</p>
            </div>
            <div class="overview__main mt-4">
                <aside>
                    <h3>{{ucfirst(__('current articles')) }}</h3>
                    <ul class="registry-list-added">
                        @foreach ($current_articles as $article)
                            <li>{{ $article['name'] }}</li>
                        @endforeach 
                    </ul>
                    <a href="{{ route('registry.overview', ['id' => $registry->id])}}" class="overview__btn link-btn my-2">{{__('overview')}}</a>
                </aside>
                <div class="overview__items">
                    @include('partials.articles-filter')

                    @if($errors->any())
                        <p class="mt-4 text-red-500">{{$errors->first()}}</p>
                    @endif
                    <div class="grid md:grid-cols-4 grid-cols-2 sm:grid-cols-2 lg:gird-cols-4 gap-4 mt-4">
                        @foreach ($articles as $article)
                            @include('articles.add', ['reg_id' => $registry->id, 'id_array' => $id_array ])
                        @endforeach
                    </div>
                    <div class="my-4">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection