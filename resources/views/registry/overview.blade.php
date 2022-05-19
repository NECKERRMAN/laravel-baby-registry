@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('overview'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center justify-between mb-8">
                <a class="link-btn" href="{{ route('registry.all')}}"> &#8249; Back</a>
                <a class="link-btn" href="{{ route('registry.addArticles', ['id' => $registry->id ])}}"> Add new articles</a>
            </div>
            <div>
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th width="50" class="py-3">Image</th>
                            <th width="400" class="py-3">{{ __('name')}}</th>
                            <th width="200" class="py-3">Category</th>
                            <th width="50" class="py-3">Action</th>
                            <th width="50" class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            @include('registry.overview-item', ['registry_id' => $registry->id])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection