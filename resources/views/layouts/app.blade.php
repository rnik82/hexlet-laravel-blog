<!-- Макет, хранится в layouts -->
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hexlet Blog - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<!-- BEGIN (начало моего эксперимента) -->
<div class="mt-4">
    <a href="/">Home</a>
    <a href="/about">About</a>
    <!-- BEGIN (write your solution here) -->
    <!-- END -->
</div>
<!-- END (конец моего эксперимента) -->
<div class="container mt-4">
    <h1>@yield('header')</h1>
    <div>
        @yield('content')
    </div>
</div>
</body>
</html>
