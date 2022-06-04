@extends('layouts.app')

@section('page-title')
    {{ ucfirst(__('all users'))}}
@endsection

@section('content')
    <div class="page-wrapper">
        <h1>{{ucfirst(__('all users'))}}</h1>
        <ul>
            <li>
                @foreach ($users as $user)
                    @include('admin.user-item')
                @endforeach
            </li>
        </ul>
    </div>
@endsection