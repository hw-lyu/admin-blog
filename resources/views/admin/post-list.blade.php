@extends('admin.layouts.default')
@section('title', '글 리스트')
@section('right-content')
    <form action="{{ route('post.create') }}" method="get">
        @csrf
        <div class="flex justify-end mb-5">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>
    <table class="table-fixed w-full">
        <colgroup>
            <col style="width:5%;">
            <col style="width:10%;">
            <col style="">
            <col style="width:10%;">
            <col style="width:10%;">
            <col style="width:10%;">
        </colgroup>
        <thead>
        <tr>
            <th>No</th>
            <th>메뉴명<br>(영문메뉴명)</th>
            <th>제목</th>
            <th>썸네일</th>
            <th>태그리스트</th>
            <th>글 공개여부</th>
        </tr>
        </thead>
        <tbody>
        @foreach($post as $list)
            <tr>
                <td class="text-center">{{ $list['id'] }}</td>
                <td class="text-center">{!! !empty($list['menu']) ? (!$list['menu']['is_blind'] ? '<i class="fa-solid fa-lock"></i> ' : '').$list['menu']['name'] : '-'  !!}
                    ({{ !empty($list['menu']) ? $list['menu']['name_eng'] : '-' }})
                </td>
                <td class="text-left"><a href="{{ route('post.show', ['post' => $list['id']]) }}">{{ $list['name'] }}</a>
                </td>
                <td class="text-center">{!! !empty($list['thumbnail']) ? "<img src='//lumii-photo.s3.ap-northeast-2.amazonaws.com/{$list['thumbnail']['file_path']}' alt=''>" : '-' !!}</a>
                </td>
                <td class="text-left">{{ implode('|', json_decode($list['tag_list'], true)) }}</td>
                <td class="text-center">{{ $list['is_blind'] === 1 ? '공개' : '비공개' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="flex justify-center mt-3">
        {{ $post->links() }}
    </div>
@endsection
