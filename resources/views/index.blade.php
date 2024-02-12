@extends('layouts.default')
@section('right-content')
    <table class="w-full table-fixed text-left">
        <colgroup>
            <col style="width:100px;">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th>블로그명</th>
            <td><input type="text" class="w-full form-input" name="name"></td>
        </tr>
        <tr>
            <th>별명</th>
            <td><input type="text" class="w-full form-input" name="nick_name"></td>
        </tr>
        <tr>
            <th>자기소개</th>
            <td>
                <textarea class="w-full form-textarea" name="introduce"></textarea>
            </td>
        </tr>
        <tr>
            <th>프로필 사진</th>
            <td>
                <input type="file" name="profile">
            </td>
        </tr>
        <tr>
            <th>불로그 커버 이미지</th>
            <td>
                <input type="file" name="cover_img">
            </td>
        </tr>
        </tbody>
    </table>
@endsection
