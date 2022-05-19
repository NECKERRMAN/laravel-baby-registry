@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/dashboard.js') }}" defer></script>
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>{{ucfirst(__('new_registry'))}}</h1>
        @include('registry.form', [
            'action' => route('registry.create'),
            'registry' => null
        ])
    </div>
@endsection