@extends('layouts.app')

@section('page-title')
  {{ ucfirst(__('home'))}}
@endsection

@section('content')
<div class="banner">
  <p class="banner__title">{{ ucfirst(__('callout'))}}</p>
  <p class="banner__subtitle">{{ ucfirst(__('callout_question'))}}</p>
  <div class="banner__img">
    <img src="/images/storksie-logo.png" alt="storksie-logo" class="w-20 h-20">
  </div>
  <div class="banner__content">
    @if(!empty($message))
        <div class="text-red-500"> {{ $message }}</div>
    @endif
    <h2>{{ ucfirst(__('callout_why'))}}</h2>
    <ul class="italic">
      <li>{{ ucfirst(__('callout_nostress'))}}</li>
      <li>{{ ucfirst(__('callout_multipleshops'))}}</li>
      <li>{{ ucfirst(__('callout_safe'))}}</li>
      <li>{{ ucfirst(__('callout_overview'))}}</li>
    </ul>
  </div>
  @auth
  <a href="{{ route('registry.all')}}" class="text-sm text-center text-gray-700 dark:text-gray-500 rounded px-4 my-2 py-2 border-2	border-gray-700">{{ __('new_list')}}</a>
  @endauth
  @guest
  <a href="/login" class="text-sm text-center text-gray-700 dark:text-gray-500 rounded px-4 my-2 py-2 border-2	border-gray-700">{{ strtoupper(__('Login'))}}</a>
  <p class="m-2">Of</p>
  <a href="/register" class="m-2 text-sm text-gray-700 dark:text-gray-500 underline">{{ ucfirst(__('new_account'))}}</a>
  @endguest
</div>

@endsection

@section('title')

@endsection