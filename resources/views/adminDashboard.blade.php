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
            <div class="admin-dashboard__title">
                <p>Admin dashboard</p>
            </div>
            <div class="admin-dashboard__content">
                <a class="admin-dashboard__btn" href="#">
                    <div>
                        <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
                        <p>Scraper</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="#">
                    <div>
                        <i class="fa-solid fa-certificate"></i>
                        <p>All Categories</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="#">
                    <div>
                        <i class="fa-solid fa-basket-shopping"></i>
                        <p>All Products</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="#">
                    <div>
                        <i class="fa-solid fa-list-ul"></i>
                        <p>All Registries</p>
                    </div>
                </a>
                <a class="admin-dashboard__btn" href="#">
                    <div>
                        <i class="fa-solid fa-users"></i>
                        <p>All Users</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection