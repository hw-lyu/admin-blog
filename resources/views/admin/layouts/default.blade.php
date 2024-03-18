<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>블로그 어드민 - @yield('title', '메인')</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-w-[1180px]">
@include('admin.common.toast-popup')
@include('admin.common.header')
<section class="main-container">
    <h2 class="sr-only">본문</h2>
    <div class="flex h-auto min-h-full">
        @include('admin.common.left-menu', ['path' => explode('/', request()->path())[0] ?: 'information'])
        <div class="right-wrap py-5 pl-7">
            @yield('right-content')
        </div>
    </div>
</section>
<script>
    const USER = {
        email: '{{ Crypt::encryptString(Request::user()->email) }}',
        password: '{{ Request::session()->get('encrypt_password') }}',
    }
</script>
</body>
</html>
