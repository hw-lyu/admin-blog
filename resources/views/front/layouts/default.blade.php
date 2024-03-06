<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>블로그 - @yield('title', '메인')</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/front-app.css', 'resources/js/front-app.js'])
</head>
<body>

@php
    /*
     * 블로그 인포메이션
     * 블로그 메뉴
     * */
    $blogInfo = \App\Models\BlogInformation::latest()->first() ?? [
        'nick_name' => '',
        'name' => '',
        'name_eng' => ''
    ];
    $blogMenu = \App\Models\BlogMenu::selectRaw('id, name, name_eng, is_blind, sort')
            ->where('is_blind', 1)
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray() ?? [
            'id' => '',
            'name' => '',
            'is_blind' => '',
            'sort' => ''
        ];
@endphp

@include('front.common.header', ['blogInfo' => $blogInfo, 'blogMenu' => $blogMenu])
<section class="main-container">
    <h2 class="sr-only">본문</h2>
    <div>
        @yield('content')
    </div>
</section>
@include('front.common.footer', [['blogInfo' => $blogInfo]])
</body>
</html>
