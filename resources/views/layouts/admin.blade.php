<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} - @yield('title')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
    @include('include.nav')

    @include('include.sidebar')


    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            @yield('main')
        </div>
    </div>


</body>

</html>
