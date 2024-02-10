<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Main')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('common.header')
<div class="px-3">
    <div class="flex">
        @include('common.left-menu')
        <div class="right-wrap py-5 pl-7">
            @yield('right-content')
        </div>
    </div>
</div>
</body>
</html>
