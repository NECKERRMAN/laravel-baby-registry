@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <h1 class="text-center">{{ucfirst($registry->name)}}</h1>
        <div>
            <div class="flex items-center mb-8">
                <a class="link-btn" href="{{ route('registry.all')}}"> &#8249; Back</a>
                <p class="ml-4">Let's add some articles</p>
            </div>
            <div>
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th width="200" class="p-3">Image</th>
                            <th width="400" class="p-3">Name</th>
                            <th width="200" class="p-3">Category</th>
                            <th width="50" class="p-3">Action</th>
                            <th width="50" class="p-3">Status</th>
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