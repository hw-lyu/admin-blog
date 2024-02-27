@extends('layouts.default')
@section('right-content')
    <form action="" method="post" name="write_form">
        <label class="flex flex-col">
            <span class="mb-1">메뉴 선택</span>
            <select name="menu" class="mb-5">
                @foreach($menus as $menu)
                    <option value="{{ $menu['id'] }}">{{ $menu['blogMenu'] }}({{ $menu['blogMenuEng'] }})</option>
                @endforeach
            </select>
        </label>
        <div id="editor"></div>
        <div class="flex justify-center mt-5">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>
@endsection
