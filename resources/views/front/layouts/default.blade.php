@php
    /*
     * 블로그 인포메이션
     * */
    $blogInfo = \App\Models\BlogInformation::latest()->first() ?? [
        'nick_name' => '',
        'name' => '',
        'introduce' => '',
        'name_eng' => ''
    ];

    /*
     * 블로그 메뉴
     * */
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

    /*
     * 메타태그 기본값
     * */
    $title = trim(mb_substr($blogInfo['name'], 0, 25, 'utf-8')). '...';
    $introduce = trim(mb_substr($blogInfo['introduce'], 0, 25, 'utf-8')). '...';
    $url = Request()->url();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="@yield('og:title', $title)"/>
    <meta property="og:description" content="@yield('og:description', $introduce)"/>
    <meta property="og:url" content="@yield('og:url', $url)"/>
    <title>블로그 - @yield('title', '메인')</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/front-app.css', 'resources/js/front-app.js'])
</head>
<body>
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
