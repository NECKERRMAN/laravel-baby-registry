@extends('layouts.app')

@section('content')
<div class="banner">
  <p class="banner__title">He jij daar!</p>
  <p class="banner__subtitle">Op zoek naar een gepersonaliseerde geboortelijst?</p>
  <div class="banner__img">
    <img src="/images/storksie-logo.png" alt="storksie-logo" class="w-20 h-20">
  </div>
  <div class="banner__content">
    <h2>Waarom kiezen voor Storksie?</h2>
    <ul class="italic">
      <li>Geen zorgen meer bij het opstellen van een geboortelijst</li>
      <li>Keuze uit meerdere shops</li>
      <li>Beveiligde toegang voor familie & vrienden</li>
      <li>Makkelijk overzicht van gereserveerde items</li>
    </ul>
  </div>
  @auth
  <a href="/login" class="text-sm text-center text-gray-700 dark:text-gray-500 rounded px-4 my-2 py-2 border-2	border-gray-700">{{ __('new_list')}}</a>
  @endauth
  @guest
  <a href="/login" class="text-sm text-center text-gray-700 dark:text-gray-500 rounded px-4 my-2 py-2 border-2	border-gray-700">Login</a>
  <p class="m-2">Of</p>
  <a href="/register" class="m-2 text-sm text-gray-700 dark:text-gray-500 underline">{{ ucfirst(__('new_account'))}}</a>
  @endguest
</div>

@endsection

@section('title')

@endsection