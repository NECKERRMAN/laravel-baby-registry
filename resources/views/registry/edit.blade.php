@extends('layouts.app');

@section('page-title')
   {{ ucfirst(__('edit registry'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1> {{ ucfirst(__('edit registry'))}}</h1>
        <div>
            @include('registry.form', [
                'action' => route('registry.update', $registry->id),
                'registry' => $registry
            ])
        </div>
    </div>
@endsection

