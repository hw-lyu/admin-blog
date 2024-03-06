@extends('front.layouts.default')
@section('title', '디테일')
@section('content')
    <div class="title-image-box"
         style="{!! !empty($view['thumbnail']) ? "background-image: url('//lumii-photo.s3.ap-northeast-2.amazonaws.com/{$view['thumbnail']['file_path']}')" : '' !!}">
        <div class="inner text-white">
            <div>조회수 테스트 {{ $view['view_count'] }}</div>
            <div class="cate">{{ $view['menu']['name'] ?? '-' }}</div>
            <p class="text-center text-4xl mt-2 line-clamp-2">{{ $view['name'] }}</p>
            <p class="text-right mt-2 line-clamp-1">{{ $view['created_at'] }}</p>
        </div>
    </div>
    <div class="inner my-5 py-5">
        {!! $view['content'] !!}
    </div>
@endsection
