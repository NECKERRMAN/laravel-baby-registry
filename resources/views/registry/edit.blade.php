@extends('layouts.app');

@section('page-title')
   {{ ucfirst(__('edit registry'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <a class="link-btn mb-4" href="{{ route('registry.all')}}">{{ __('back')}}</a>
        <h1> {{ ucfirst(__('edit registry'))}}</h1>
        <div>
            @include('registry.form', [
                'action' => route('registry.update', $registry->id),
                'registry' => $registry
            ])
        </div>
    </div>
@endsection

