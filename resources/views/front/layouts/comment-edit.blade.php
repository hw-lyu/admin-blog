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
    <div class="comment-edit">
        <button type="button" data-mode="edit" class="active">수정</button>
        <button type="button" data-mode="delete">삭제</button>
    </div>
    <form action="" method="get" name="comment_form"
          class="comment-form">
        @csrf
        <div class="px-5 mt-5 text-center">
            <label class="flex flex-col items-start justify-center">
                <span class="mb-1">이름</span>
                <input type="text" class="w-full" name="name" value="{{ $comment['name'] }}"required>
            </label>
            <label class="flex flex-col items-start justify-center mt-5">
                <span class="mb-1">비밀번호</span>
                <input type="password" class="w-full" name="password" placeholder="비밀번호는 다시 재등록해주세요." required>
            </label>
            <label class="flex flex-col items-start justify-center mt-5">
                <span class="mb-1">내용</span>
                <textarea class="w-full">{{ $comment['content'] }}</textarea>
            </label>
            <div class="flex flex-col items-start justify-center mt-5">
                <label class="w-full flex flex-col items-start justify-center">
                    <span class="mb-1">기존 업로드된 파일명 <span class="text-sm">(*기존에 썼었던 이미지 파일)</span></span>
                    <input type="text" class="w-full border-gray-300" name="now_file" value="{{ $comment['commentFile']['file_name'] }}" readonly>
                </label>
                <label for="commentFile" class="mb-1 mt-3">새로 파일 업로드 <span class="text-sm">(*새로 파일 업로드할 시 기존 파일에서 교체)</span></label>
                <input type="file" class="w-full" id="commentFile" name="comment_file" readonly>
            </div>
            <div class="flex justify-center w-2/6 mt-5 mx-auto">
                <button type="button" class="w-3/6 py-2 px-3 bg-gray-200 btn-send">확인</button>
                <button type="button" class="w-3/6 py-2 px-3 border border-gray-200" onclick="window.close();">취소
                </button>
            </div>
        </div>
    </form>
</div>
@include('front.common.toast-popup')

{{--<script>--}}
{{--    let commentEdit = document.querySelector('.comment-edit'),--}}
{{--        commentForm = document.querySelector('.comment-form'),--}}
{{--        inputEdit = document.querySelector('input[name="mode"]'),--}}
{{--        inputMethod = document.querySelector('input[name="_method"]'),--}}
{{--        btnSend = document.querySelector('.btn-send');--}}

{{--    commentEdit.addEventListener('click', (e) => {--}}
{{--        let eTarget = e.target,--}}
{{--            modeValue = eTarget.dataset.mode,--}}
{{--            commentForm = document.forms.comment_form;--}}

{{--        inputEdit.value = modeValue;--}}
{{--        inputMethod.value = (modeValue === 'edit') ? 'get' : 'delete';--}}
{{--        commentForm.method = (modeValue === 'edit') ? 'get' : 'post';--}}
{{--        commentForm.action = (modeValue === 'edit') ? '{{ route('front.comments.edit', ['comment' => $commentId]) }}' : '{{ route('front.comments.destroy', ['comment' => $commentId]) }}';--}}

{{--        [...commentEdit.querySelectorAll('button')].map(ele => {--}}
{{--            ele.classList.remove('active');--}}
{{--        });--}}

{{--        commentEdit.querySelector(`button[data-mode="${modeValue}"]`).classList.add('active');--}}
{{--    });--}}

{{--    btnSend.addEventListener('click', () => {--}}

{{--        // if (inputEdit.value === 'delete') {--}}
{{--        //     let con = confirm('정말 삭제하시겠습니까?');--}}
{{--        //--}}
{{--        //     if (con) {--}}
{{--        //         return document.forms.comment_form.submit();--}}
{{--        //     }--}}
{{--        //--}}
{{--        //     return false;--}}
{{--        // }--}}
{{--        //--}}
{{--        // return document.forms.comment_form.submit();--}}
{{--    });--}}

{{--</script>--}}
</body>
</html>
