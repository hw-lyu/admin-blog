@extends('front.layouts.default')
@section('og:title', trim(mb_substr(strip_tags($view['name']), 0, 30, 'utf-8')). '...')
@section('og:description', trim(mb_substr(strip_tags($view['content']), 0, 30, 'utf-8')). '...')
@section('og:url', Request()->url())
@section('title', trim(mb_substr(strip_tags($view['name']), 0, 30, 'utf-8')). '...')
@section('content')
    <div class="title-image-box"
         style="{!! !empty($view['thumbnail']) ? "background-image: url('".config('app.s3_thumb_url').$view['thumbnail']['file_path']."')" :  "background-image: url('".config('app.no_thumb_url')."')" !!}">
        <div class="inner text-white">
            <div class="cate">{{ $view['menu']['name'] ?? '-' }}</div>
            <p class="text-center text-4xl mt-2 line-clamp-3">{{ $view['name'] }}</p>
            <p class="text-right mt-2 line-clamp-1">{{ $view['created_at'] }}</p>
        </div>
    </div>
    <div class="inner my-5 py-5">
        <div class="toastui-editor-contents">
            {!! $view['content'] !!}
        </div>
        <ul class="tag-list">
            @foreach(json_decode($view['tag_list']) as $tag)
                <li><a href="/hash?hashtag={{ $tag }}">#{{ $tag }}</a></li>
            @endforeach
        </ul>
    </div>
    <hr class="my-5">
    <div class="comment-list-wrap">
        <div class="inner">
            <p class="my-2">총 {{ count($view['comment']) }}</p>
            @foreach($view['comment'] as $comment)
                <div class="comment mt-2">
                    <div class="text-sm flex justify-between">
                        <div class="flex">
                            <p class="mr-3">{{ $comment['name'] }}</p>
                            <p>{{ $comment['created_at'] }}</p>
                        </div>
                        <button type="button"
                                data-url="{{ route('front.comments.enter', ['comment' => $comment['id'] ]) }}"
                                class="btn-edit">수정/삭제
                        </button>
                    </div>
                    @if(!empty($comment['commentFile']))
                        <div class="my-2">
                            <img src="{{ config('app.s3_thumb_url').$comment['commentFile']['file_path'] }}" alt="">
                        </div>
                    @endif
                    <p class="mt-1">{!! $comment['content'] !!}</p>
                    <hr class="my-5 border-gray-300">
                </div>
            @endforeach
        </div>
    </div>
    <form action="{{ route('front.comments.store') }}" name="comment_form" class="mt-5" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $postInfo['menuId'] }}">
        <input type="hidden" name="post_id" value="{{ $postInfo['postId'] }}">
        <div class="comment-wrap">
            <div class="inner">
                <div class="relative">
                    <img src="" alt="Image preview" class="preview mb-3" draggable="false">
                    <button type="button" class="remove-btn">Remove</button>
                </div>
                <div class="comment flex flex-col">
                    <div class="flex mb-3">
                        <label class="flex flex-col"><span class="mb-2">ID</span> <input type="text" name="name"
                                                                                         placeholder="아이디를 입력해주세요."></label>
                        <label class="flex flex-col ml-3"><span class="mb-2">PW</span> <input type="password"
                                                                                              name="password"
                                                                                              placeholder="패스워드를 입력해주세요."></label>
                    </div>
                    <label for="commentContent" class="mb-2">Comment</label>
                    <div class="flex justify-between">
                        <textarea name="content" id="commentContent" cols="30" rows="5"
                                  class="w-[calc(100%-85px)]"></textarea>
                        <button type="button"
                                class="w-[70px] inline-block text-center text-sm p-2 border border-black rounded btn-add">
                            등록
                        </button>
                    </div>
                </div>
                <label class="mt-3 file-label">
                <span
                    class="inline-block w-auto text-center text-sm p-2 border border-black rounded mt-3 cursor-pointer">이미지 첨부</span>
                    <input type="file" name="comment_img" class="hidden file-input">
                </label>
            </div>
        </div>
    </form>

    <script>
        let fileInput = document.querySelector('.file-input'),
            preview = document.querySelector('.preview'),
            btnRemove = document?.querySelector('.remove-btn'),
            btnAdd = document?.querySelector('.btn-add'),
            commentListWrap = document?.querySelector('.comment-list-wrap'),
            fileRender = new FileReader();

        // 파일이 등록되면 base64로 프리뷰 인코딩
        fileInput.addEventListener('change', function (e) {
            let file = e.target.files[0];

            fileRender.addEventListener('load', (evt) => {
                preview.classList.add('show');
                // result 인터페이스의 읽기 전용 속성은 파일 FileReader 내용을 반환
                preview.src = evt.target.result;
            });

            if (file) {
                // 이때 속성에는 파일의 데이터를 base64로 인코딩된 문자열로 나타내는 data : URL 로 데이터가 포함
                fileRender.readAsDataURL(file);
            }
        });

        // 프리뷰 이미지 삭제
        btnRemove.addEventListener('click', () => {
            fileInput.value = "";
            preview.src = "";
            preview.classList.remove('show');
        });

        btnAdd.addEventListener('click', () => {
            let con = confirm("코멘트를 등록하시겠습니까?");

            if (con) {
                document.forms.comment_form.submit();
            }
        });

        commentListWrap.addEventListener('click', (e) => {
            let eTarget = e.target;

            if (eTarget.classList.contains('btn-edit')) {
                window.open(eTarget.dataset.url, "popupEdit", "top=300, left=500 ,width=400, height=400");
            }
        });
    </script>
@endsection
