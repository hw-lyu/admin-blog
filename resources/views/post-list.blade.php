@extends('layouts.default')
@section('right-content')
    <form action="{{ route('post.create') }}" method="get">
        @csrf
        <div class="flex justify-end mb-5">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>
    <table class="table-fixed w-full">
        <colgroup>
            <col style="width:10%;">
            <col style="">
            <col style="width:30%;">
        </colgroup>
        <thead>
        <tr>
            <th>메뉴명</th>
            <th>제목</th>
            <th>태그리스트</th>
        </tr>
        </thead>
        <tbody>
        @foreach($post as $val)
            <tr>
                <td class="text-center">{{ !empty($val['menu']) ? $val['menu']['name'] : '-' }}
                    ({{ !empty($val['menu']) ? $val['menu']['name_eng'] : '-' }})
                </td>
                <td class="text-left"><a href="{{ route('post.show', ['post' => $val['id']]) }}">{{ $val['name'] }}</a>
                </td>
                <td class="text-center">{{ implode('|', json_decode($val['tag_list'], true)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="flex justify-center mt-3">
        {{ $post->links() }}
    </div>
@endsection