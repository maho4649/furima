<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'フリマアプリ')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="logo-header">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('storage/logo.svg') }}" alt="Logo">
        </a>
    </header>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
