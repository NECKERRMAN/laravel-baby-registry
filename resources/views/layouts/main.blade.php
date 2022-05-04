<!DOCTYPE html>
<html lang="nl">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Storksie</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://kit.fontawesome.com/9502bf1d06.js" crossorigin="anonymous"></script>
    <meta class="foundation-mq">
</head>

<body class="bg-green-100">
    @include('partials.header')

    <main class="max-w-screen-xl m-auto mt-5 mb-5">
        @yield('title')

        @yield('content')

    </main>
</body>

</html>