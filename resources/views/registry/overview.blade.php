@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('overview'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center justify-between mb-8">
                <a class="link-btn" href="{{ route('registry.all')}}"> &#8249; {{__('back')}}</a>
                <a class="link-btn" href="{{ route('registry.addArticles', ['id' => $registry->id ])}}">&#x2B; {{ __('add new articles')}}</a>
            </div>
            <div class="mb-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th width="50" class="py-3">{{ ucfirst(__('image')) }}</th>
                            <th width="400" class="py-3">{{ ucfirst(__('name'))}}</th>
                            <th width="200" class="py-3">{{ ucfirst(__('category')) }}</th>
                            <th width="50" class="py-3">{{ ucfirst(__('action')) }}</th>
                            <th width="50" class="py-3">{{ ucfirst(__('status')) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            @include('registry.overview-item', ['registry_id' => $registry->id])
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-4"> 
                <button class="px-4 py-2 rounded border-2 border-[#9ec4c5] text-[#9ec4c5]">Export <i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
@endsection