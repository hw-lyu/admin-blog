@extends('layouts.default')
@section('right-content')
    <form action="{{ route('information.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <table class="w-full table-fixed text-left">
            <colgroup>
                <col style="width:100px;">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th><label for="blogName">블로그명</label></th>
                <td><input type="text" id="blogName" class="w-full form-input" name="name" value="{{ $data['name'] }}"></td>
            </tr>
            <tr>
                <th><label for="nickName">별명</label></th>
                <td><input type="text" id="nickName" class="w-full form-input" name="nick_name" value="{{ $data['nick_name'] }}"></td>
            </tr>
            <tr>
                <th><label for="blogIntroduce">자기소개</label></th>
                <td>
                    <textarea id="blogIntroduce" class="w-full form-textarea" name="introduce">{{ $data['introduce'] }}</textarea>
                </td>
            </tr>
            <tr>
                <th><label for="blogProfileImg">프로필 사진</label></th>
                <td>
                    <div class="flex flex-col mb-1">
                        <label class="flex flex-col">현재 파일명 : <input type="text" class="p-1" name="now_profile_img" value="{{ $data['profile_img_path'] }}" readonly></label>
                        <img src="//lumii-photo.s3.ap-northeast-2.amazonaws.com/{{ $data['profile_img_path'] }}" alt="" width="150">
                    </div>
                    <input type="file" id="blogProfileImg" name="profile_img">
                </td>
            </tr>
            <tr>
                <th><label for="blogCoverImg">불로그 커버 이미지</label></th>
                <td>
                    <div class="flex flex-col mb-1">
                        <label class="flex flex-col">현재 파일명 : <input type="text" class="p-1" name="now_cover_img" value="{{ $data['cover_img_path'] }}" readonly></label>
                        <img src="//lumii-photo.s3.ap-northeast-2.amazonaws.com/{{ $data['cover_img_path'] }}" alt="" width="150">
                    </div>
                    <input type="file" id="blogCoverImg" name="cover_img">
                </td>
            </tr>
            </tbody>
        </table>
        <div class="flex justify-center mt-2">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>
@endsection
