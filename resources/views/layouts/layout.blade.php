<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} - @yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    @yield('main')
</body>

</html>