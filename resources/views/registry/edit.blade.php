@extends('layouts.app');

@section('page-title')
   {{ ucfirst(__('edit registry'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <a class="link-btn mb-4" href="{{ route('registry.all')}}">{{ __('back')}}</a>
        <div class="flex justify-between items-center">
            <h1> {{ ucfirst(__('edit registry'))}}</h1>
            <form method="POST" action="{{ route('registry.delete')}}">
                @csrf
                <input type="hidden" name="registry_id" value="{{ $registry->id }}">
                <button type="submit" class="py-2 px-4 rounded border-2 border-red-500 text-red-500">{{ ucfirst(__('delete'))}}</button>
            </form>
        </div>
        <div>
            @include('registry.form', [
                'action' => route('registry.update', $registry->id),
                'registry' => $registry
            ])
        </div>
    </div>
@endsection

