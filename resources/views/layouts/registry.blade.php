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
    <header class="p-4 pb-2">
          <div class="flex flex-col items-center mb-4">
            <img src="/images/storksie-logo.png" alt="storksie-logo" class="w-20 h-20">
            <h1>Storksie</h1>
            </div>
      </header>
    <main class="max-w-screen-xl m-auto mt-5 mb-5">
        @yield('title')

        @yield('content')

    </main>
</body>

</html>