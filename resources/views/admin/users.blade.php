@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('Admin | All users'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>All users</h1>
        <ul>
            <li>
                @foreach ($users as $user)
                    @include('admin.user-item')
                @endforeach
            </li>
        </ul>
    </div>
@endsection