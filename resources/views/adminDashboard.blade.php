@extends('layouts.app')

@section('header')
    <h1>{{ ucfirst(__('welcome_back'))}} {{strtoupper(__('admin'))}}</h1>
@endsection

@section('page-title')
    {{ucfirst(__('admin dashboard'))}}
@endsection

@section('content')
    <div class="page-wrapper py-12">
        <div class="admin-dashboard">
            <div class="admin-dashboard__title mb-4">
                <p>{{ucfirst(__('admin dashboard'))}}</p>
            </div>
            <div class="admin-dashboard__overview">
                <div>
                    <p>{{ ucfirst(__('number of users')) }}: {{ $n_users }}</p>
                    <p>{{ ucfirst(__('number of articles')) }}: {{ $n_art }}</p>
                    <p>{{ ucfirst(__('number of registries')) }}: {{ $n_reg }}</p>
                </div>
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
            <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-4">
                <a class="admin-dashboard__btn" href="{{ route('admin.scrape') }}">
                    <div>
                        <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
                        <p>{{ ucfirst(__('scraper'))}}</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.categories') }}">
                    <div>
                        <i class="fa-solid fa-certificate"></i>
                        <p>{{ ucfirst(__('all categories'))}}</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.articles') }}">
                    <div>
                        <i class="fa-solid fa-basket-shopping"></i>
                        <p>{{ ucfirst(__('all articles'))}}</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.registries') }}">
                    <div>
                        <i class="fa-solid fa-list-ul"></i>
                        <p>{{ ucfirst(__('all registries'))}}</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.users') }}">
                    <div>
                        <i class="fa-solid fa-users"></i>
                        <p>{{ ucfirst(__('all users'))}}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection