<!-- Макет, хранится в layouts -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Laravel Blog - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="container mt-4">
        <div>
            <a class="navbar-brand" href="/">PHP Laravel Blog</a>
            <a href="{{ route('about') }}">Home</a>
            <a href="{{ route('articles.index') }}">Статьи</a>
            <a href="{{ route('articles.create') }}">Создать статью</a>
        </div>
        <h1>@yield('header')</h1>
        <div>
            @yield('content')
        </div>
    </div>
</body>
</html>
