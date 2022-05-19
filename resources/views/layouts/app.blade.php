<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} |
            @yield('page-title')
        </title>

        <!-- Styles -->
        @yield('stylesheet')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/9502bf1d06.js" crossorigin="anonymous"></script>
        @yield('scripts')
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-white">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{-- {{ $slot }} --}}
                @yield('content')
            </main>
        </div>
    </body>
</html>
