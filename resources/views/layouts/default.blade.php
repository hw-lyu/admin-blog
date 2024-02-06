<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @vite('resources/css/app.css')
</head>
<body>
@include('common.header')
<div class="container mx-auto">
    @include('common.gnb')
    <div class="right-wrap">
        @yield('right-content')
    </div>
</div>
</body>
</html>
