@extends('layouts.default')
@section('right-content')
    <table class="w-full table-fixed text-left">
        <colgroup>
            <col style="width:100px;">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th><label for="blogName">블로그명</label></th>
            <td><input type="text" id="blogName" class="w-full form-input" name="name"></td>
        </tr>
        <tr>
            <th><label for="nickName">별명</label></th>
            <td><input type="text" id="nickName" class="w-full form-input" name="nick_name"></td>
        </tr>
        <tr>
            <th><label for="blogIntroduce">자기소개</label></th>
            <td>
                <textarea id="blogIntroduce" class="w-full form-textarea" name="introduce"></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="blogProfile">프로필 사진</label></th>
            <td>
                <input type="file" id="blogProfile" name="profile">
            </td>
        </tr>
        <tr>
            <th><label for="blogCoverImg">불로그 커버 이미지</label></th>
            <td>
                <input type="file" id="blogCoverImg" name="cover_img">
            </td>
        </tr>
        </tbody>
    </table>
    <div class="flex justify-center mt-2">
        <button type="button" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
    </div>
@endsection
