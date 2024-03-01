@extends('layouts.default')
@section('title', '글쓰기')
@section('right-content')
    <form action="{{ route('post.store') }}" method="post" name="write_form">
        @csrf
        <label class="flex flex-col">
            <span class="mb-1">메뉴 선택</span>
            <select name="menu_id" class="mb-3">
                @foreach($menus as $menu)
                    <option value="{{ $menu['id'] }}">{{ $menu['blogMenu'] }}({{ $menu['blogMenuEng'] }})</option>
                @endforeach
            </select>
        </label>
        <input type="text" name="name" class="w-full form-input mb-3" placeholder="글 제목을 입력해주세요.">
        <div id="editor"></div>
        <input type="text" name="tag_list" class="w-full form-input mt-3" placeholder="태그를 입력해주세요. 양식 ex) 단어1|단어2">
        <textarea name="content" class="hidden"></textarea>
        <input type="hidden" name="thumbnail_id">
        <div class="hidden-tag hidden"></div>
        <div class="flex mt-5">
            <label class="mr-2"><input type="radio" name="post_state" class="mr-2" value="1">공개</label>
            <label><input type="radio" name="post_state" class="mr-2" value="0">비공개</label>
        </div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>
@endsection
