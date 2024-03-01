@extends('layouts.default')
@section('title', '글 보기')
@section('right-content')
    <form action="" method="" name="send_form">
        @csrf
        <input type="hidden" name="_method">
        <div class="flex mb-5 justify-end">
            <button type="button" class="py-2 px-5 rounded-md text-white bg-purple-500 mr-2 btn-destroy">삭제</button>
            <button type="button" class="py-2 px-5 rounded-md text-white bg-purple-500 btn-edit">수정</button>
        </div>
    </form>
    <hr>
    <div class="flex flex-col mt-5">
        <div><strong>메뉴명: </strong> {{ !empty($post['menu']) ? $post['menu']['name'] : '-' }}({{ !empty($post['menu']) ? $post['menu']['name_eng'] : '-' }})</div>
        <div class="mt-1"><strong>제목: </strong> {{ $post['name'] }}</div>
        <div class="mt-1"><strong>태그리스트: </strong> {{ implode('|', json_decode($post['tag_list'], true)) }}</div>
        <div class="mt-1"><strong>글 공개여부: </strong> {{ $post['is_blind'] === 1 ? '공개' : '비공개' }}</div>
        <textarea name="content" class="hidden">{{ $post['content'] }}</textarea>
        <div id="viewer" class="py-1 px-3 bg-gray-100 mt-3"></div>
    </div>
    <script>
        document.forms.send_form.addEventListener('click', function (e) {
            let eTarget = e.target,
                btnObj = {
                    'destroy': {
                        'method': 'POST',
                        'action': '{{ route('post.destroy', ['post' => $post['id'] ]) }}'
                    },
                    'edit': {
                        'method': 'GET',
                        'action': '{{ route('post.edit', ['post' => $post['id'] ]) }}'
                    }
                },
                method = document.querySelector('input[name="_method"]');

            if (eTarget.classList.contains('btn-destroy')) {
                this.method = btnObj.destroy.method;
                this.action = btnObj.destroy.action;
                method.value = "DELETE";
            }

            if (eTarget.classList.contains('btn-edit')) {
                this.method = btnObj.edit.method;
                this.action = btnObj.edit.action;
            }

            this.submit();
        });
    </script>
@endsection
