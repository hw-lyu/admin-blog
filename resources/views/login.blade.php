<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-w-[1180px]">

@if ($errors->any())
    <div class="absolute top-2 left-2 bg-purple-600 rounded px-5 py-2 text-white">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{route('login.authenticate')}}" method="post" class="h-full">
    @csrf
    <div class="login-box">
        <div class="flex flex-col px-20 py-10 bg-purple-600 rounded-2xl">
            <div class="flex justify-center items-center text-white">
                <div class="flex items-baseline">
                    <h1 class="common-title text-3xl mr-3 pr-3 uppercase"><a href="/">Lumii.</a></h1>
                    <div>Admin Login</div>
                </div>
            </div>
            <div class="flex flex-col items-center mt-5">
                <label class="flex flex-col"><span class="text-white mb-0.5">ID</span><input type="text" class="rounded" name="email"
                                                                                             placeholder="아이디" required></label>
                <label class="flex flex-col mt-2"><span class="text-white mb-0.5">PW</span><input type="password" name="password"
                                                                                                  class="rounded"
                                                                                                  placeholder="비밀번호" required></label>
                <div class="flex justify-center mt-5">
                    <button type="submit" class="py-2 px-5 rounded-md bg-purple-100">로그인</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
