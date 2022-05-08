@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        @foreach ($registries as $registry)
        {{ $registry->id }}
    @endforeach
    </div>
@endsection