<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>댓글 수정/삭제</title>
    @vite(['resources/css/front-app.css', 'resources/js/front-app.js'])
</head>
<body>
<div>
    <p class="py-3 px-5 bg-gray-300">댓글 수정/삭제</p>
    <div class="comment-edit">
        <button type="button" class="active">수정</button>
        <button type="button">삭제</button>
    </div>

    <form action="{{ route('front.comments.check', ['comment' => $commentId]) }}" method="post">
        @csrf
        <div class="px-5 mt-5 text-center">
            <label class="flex flex-col items-center justify-center">
                <span class="mb-5">비밀번호를 입력해주세요 :)</span>
                <input type="password" class="w-6/12" name="password" placeholder="비밀번호를 입력해주세요." required>
            </label>
            <div class="flex justify-center w-2/6 mt-5 mx-auto">
                <button type="submit" class="w-3/6 py-2 px-3 bg-gray-200">확인</button>
                <button type="button" class="w-3/6 py-2 px-3 border border-gray-200">취소</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
