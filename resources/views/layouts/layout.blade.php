<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}} - @yield('title')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-white">
    @yield('main')
</body>

</html>
