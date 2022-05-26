@extends('layouts.app')

@section('header')
    <h1>{{ ucfirst(__('welcome_back'))}} ADMIN</h1>
@endsection

@section('page-title')
    Admin Dashboard
@endsection

@section('content')
    <div class="page-wrapper py-12">
        <div class="admin-dashboard">
            <div class="admin-dashboard__title mb-4">
                <p>Admin dashboard</p>
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
                        <p>Scraper</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.categories') }}">
                    <div>
                        <i class="fa-solid fa-certificate"></i>
                        <p>All Categories</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.articles') }}">
                    <div>
                        <i class="fa-solid fa-basket-shopping"></i>
                        <p>All Products</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.registries') }}">
                    <div>
                        <i class="fa-solid fa-list-ul"></i>
                        <p>All Registries</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="{{ route('admin.users') }}">
                    <div>
                        <i class="fa-solid fa-users"></i>
                        <p>All Users</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection