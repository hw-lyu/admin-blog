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
    @if(!empty($commentId))
        <div class="comment-edit">
            <button type="button" data-mode="edit" class="active">수정</button>
            <button type="button" data-mode="delete">삭제</button>
        </div>
        <form action="{{ route('front.comments.edit', ['comment' => $commentId]) }}" method="get" name="comment_form"
              class="comment-form">
            @csrf
            <input type="hidden" name="_method" value="get">
            <input type="hidden" name="mode" value="edit">
            <div class="px-5 mt-5 text-center">
                <label class="flex flex-col items-center justify-center">
                    <span class="mb-5">비밀번호를 입력해주세요 :)</span>
                    <input type="password" class="w-6/12" name="password" placeholder="비밀번호를 입력해주세요." required>
                </label>
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

@if(!empty($commentId))
    <script>
        let commentEdit = document.querySelector('.comment-edit'),
            commentForm = document.querySelector('.comment-form'),
            inputEdit = document.querySelector('input[name="mode"]'),
            inputMethod = document.querySelector('input[name="_method"]'),
            btnSend = document.querySelector('.btn-send');

        commentEdit.addEventListener('click', (e) => {
            let eTarget = e.target,
                modeValue = eTarget.dataset.mode,
                commentForm = document.forms.comment_form;

            inputEdit.value = modeValue;
            inputMethod.value = (modeValue === 'edit') ? 'get' : 'delete';
            commentForm.method = (modeValue === 'edit') ? 'get' : 'post';
            commentForm.action = (modeValue === 'edit') ? '{{ route('front.comments.edit', ['comment' => $commentId]) }}' : '{{ route('front.comments.destroy', ['comment' => $commentId]) }}';

            [...commentEdit.querySelectorAll('button')].map(ele => {
                ele.classList.remove('active');
            });

            commentEdit.querySelector(`button[data-mode="${modeValue}"]`).classList.add('active');
        });

        btnSend.addEventListener('click', () => {

            if (inputEdit.value === 'delete') {
                let con = confirm('정말 삭제하시겠습니까?');

                if (con) {
                    return document.forms.comment_form.submit();
                }

                return false;
            }

            return document.forms.comment_form.submit();
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
