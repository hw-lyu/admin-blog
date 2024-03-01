@extends('layouts.default')
@section('title', '글 수정')
@section('right-content')
    <form action="" method="" name="send_form">
        @csrf
        <input type="hidden" name="_method">
        <input type="hidden" name="destroy_action" value="{{ route('post.destroy', ['post' => $post['id'] ]) }}">
        <input type="hidden" name="update_action" value="{{ route('post.update', ['post' => $post['id'] ]) }}">
        <div class="flex mb-5 justify-end">
            <button type="button" class="py-2 px-5 rounded-md text-white bg-purple-500 mr-2 btn-destroy">삭제</button>
            <button type="button" class="py-2 px-5 rounded-md text-white bg-purple-500 btn-update">수정</button>
        </div>
        <hr>
        <div class="flex flex-col mt-5">
            <label class="flex flex-col">
                <span class="mb-1">메뉴 선택</span>
                <select name="menu_id" class="mb-3">
                    @foreach($menus as $menu)
                        <option value="{{ $menu['id'] }}" {{$post['menu_id'] === $menu['id'] ? 'selected' : ''}}>{{ $menu['blogMenu'] }}({{ $menu['blogMenuEng'] }})</option>
                    @endforeach
                </select>
            </label>
            <label class="mt-1">제목 <input type="text" name="name" class="w-full form-input mb-1"
                                          value="{{ $post['name'] }}"></label>
            <label class="mt-1">태그리스트 <input type="text" name="tag_list" class="w-full form-input mb-1"
                                             value="{{ implode('|', json_decode($post['tag_list'], true)) }}"></label>
            <textarea name="content" class="hidden">{{$post['content']}}</textarea>
            <div id="editor" class="py-1 mt-3"></div>
        </div>
    </form>
@endsection
