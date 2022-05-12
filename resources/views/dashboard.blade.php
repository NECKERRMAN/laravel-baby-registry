@extends('layouts.app')

@section('header')
    <h1>{{ ucfirst(__('welcome_back'))}}</h1>
@endsection

@section('content')
    <div class="py-12 dashboard">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <h1>{{ ucfirst(__('how does Storksie work?'))}}</h1>
                   <ul class="dashboard__list mb-8">
                       <li>{{ ucfirst(__('make a registry'))}}</li>
                       <li>{{ucfirst(__('name_birthdate'))}}</li>
                       <li>{{ucfirst(__('select_articles'))}}</li>
                       <li>{{ucfirst(__('send_link'))}}</li>
                       <li class="font-bold">{{ucfirst(__('important_password'))}} <a href="/my-lists" class="underline">{{__('my_lists')}}</a> - {{__('passwords')}}</li>
                   </ul>

                   <a class="my-2 p-4 rounded border-2" href="{{ route('registry.all')}}">Naar mijn geboortelijst(en)</a>
                </div>
            </div>
        </div>
    </div>
@endsection