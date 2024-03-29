@extends('admin.layouts.default')
@section('title', '메인')
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
                        <label><input type="hidden" class="p-1" name="now_profile_id" value="{{ !empty($data['profileFile']['id']) ? $data['profileFile']['id'] : '' }}"></label>
                        <label class="flex flex-col">현재 파일명 : <input type="text" class="p-1" name="now_profile_img" value="{{ !empty($data['profileFile']['file_path']) ? $data['profileFile']['file_path'] : '' }}" readonly></label>
                        <img src="//lumii-photo.s3.ap-northeast-2.amazonaws.com/{{ !empty($data['profileFile']['file_path']) ? $data['profileFile']['file_path'] : '' }}" alt="" width="150">
                    </div>
                    <input type="file" id="blogProfileImg" name="profile_img">
                </td>
            </tr>
            <tr>
                <th><label for="blogCoverImg">불로그 커버 이미지</label></th>
                <td>
                    <div class="flex flex-col mt-2 mb-1">
                        <label><input type="hidden" class="p-1" name="now_cover_id" value="{{ !empty($data['coverFile']['id']) ? $data['coverFile']['id'] : '' }}"></label>
                        <label class="flex flex-col">현재 파일명 : <input type="text" class="p-1" name="now_cover_img" value="{{ !empty($data['coverFile']['file_path']) ? $data['coverFile']['file_path'] : '' }}" readonly></label>
                        <img src="//lumii-photo.s3.ap-northeast-2.amazonaws.com/{{ !empty($data['coverFile']['file_path']) ? $data['coverFile']['file_path'] : '' }}" alt="" width="150">
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
