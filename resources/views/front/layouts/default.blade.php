<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="@yield('og:title', $meta['title'])"/>
    <meta property="og:description" content="@yield('og:description', $meta['introduce'])"/>
    <meta property="og:url" content="@yield('og:url', $meta['url'])"/>
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
