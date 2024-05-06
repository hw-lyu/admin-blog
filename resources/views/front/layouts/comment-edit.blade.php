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
<div class="comment-wrap">
    <p class="py-3 px-5 bg-gray-300">댓글 수정/삭제</p>
    @if(!empty($comment))
        <div class="comment-edit">
            <button type="button" class="active">수정</button>
            <button type="button" class="btn-delete">삭제</button>
        </div>
        <form action="{{ route('front.comments.update', ['comment' => $comment['id']]) }}" method="post"
              name="comment_form"
              class="comment-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="patch">
            <div class="px-5 mt-5 text-center">
                <label class="flex flex-col items-start justify-center">
                    <span class="mb-1">이름</span>
                    <input type="text" class="w-full" name="name" value="{{ $comment['name'] }}" required>
                </label>
                <label class="flex flex-col items-start justify-center mt-5">
                    <span class="mb-1">비밀번호</span>
                    <input type="password" class="w-full" name="password" value="{{ $original_password }}">
                </label>
                <label class="flex flex-col items-start justify-center mt-5">
                    <span class="mb-1">내용</span>
                    <textarea name="content" class="w-full">{{ $comment['content'] }}</textarea>
                </label>
                <div class="flex flex-col items-start justify-center mt-5">
                    <label class="w-full flex flex-col items-start justify-center">
                        <span class="mb-1">기존 업로드된 파일명 <span class="text-sm">(*기존에 썼었던 이미지 파일)</span></span>
                        <input type="hidden" name="now_file_id" value="{{ $comment['commentFile']['id'] }}">
                        <input type="text" class="w-full border-gray-300" name="now_file"
                               value="{{ $comment['commentFile']['file_name'] }}" readonly>
                    </label>
                    <label for="commentImg" class="mb-1 mt-3">새로 파일 업로드 <span class="text-sm">(*새로 파일 업로드할 시 기존 파일에서 교체)</span></label>
                    <input type="file" class="w-full" id="commentImg" name="comment_img">
                </div>
                <div class="flex justify-center w-2/6 mt-5 mb-5 mx-auto">
                    <button type="button" class="w-3/6 py-2 px-3 bg-gray-200 btn-send">확인</button>
                    <button type="button" class="w-3/6 py-2 px-3 border border-gray-200" onclick="window.close();">취소
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="py-10 px-5 text-center">삭제된 코멘트 입니다 :)</div>
    @endif
</div>
@include('front.common.toast-popup')
@if(!empty($comment))
    <script>
        let btnDelete = document.querySelector('.btn-delete'),
            btnSend = document.querySelector('.btn-send'),
            inputMethod = document.querySelector('input[name="_method"]');

        btnDelete.addEventListener('click', () => {
            let con = confirm('코멘트를 삭제하시겠습니까?');

            if (con) {
                inputMethod.value = 'delete';
                document.forms.comment_form.action = '{{ route('front.comments.destroy', ['comment' => $comment['id']]) }}';
                document.forms.comment_form.submit();
            }
        });

        btnSend.addEventListener('click', () => {
            inputMethod.value = 'patch';
            document.forms.comment_form.action = '{{ route('front.comments.update', ['comment' => $comment['id']]) }}';
            document.forms.comment_form.submit();
        });
    </script>
@else
    <script>
        setTimeout(() => {
            window.close();
        }, 1000);
    </script>
@endif
</body>
</html>
