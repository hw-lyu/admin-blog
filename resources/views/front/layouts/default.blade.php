<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="@yield('og:title', $meta['title'])"/>
    <meta property="og:description" content="@yield('og:description', $meta['introduce'])"/>
    <meta property="og:url" content="@yield('og:url', $meta['url'])"/>
    <title>블로그 - @yield('title', '메인')</title>
    <link rel="preload" href="//cdn.df.nexon.com/img/common/font/DNFForgedBlade-Light.otf" as="font" type="font/otf" crossorigin="anonymous">
    <link rel="preload" href="//cdn.df.nexon.com/img/common/font/DNFForgedBlade-Medium.otf" as="font" type="font/otf" crossorigin="anonymous">
    <link rel="preload" href="//cdn.df.nexon.com/img/common/font/DNFForgedBlade-Bold.otf" as="font" type="font/otf" crossorigin="anonymous">
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

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
    if(!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "7ce30a60ea9058";
    if(window.wcs) {
        wcs_do();
    }
</script>
</body>
</html>
