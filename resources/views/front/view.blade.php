@extends('front.layouts.default')
@section('og:title', trim(mb_substr(strip_tags($view['name']), 0, 30, 'utf-8')). '...')
@section('og:description', trim(mb_substr(strip_tags($view['content']), 0, 30, 'utf-8')). '...')
@section('og:url', Request()->url())
@section('title', trim(mb_substr(strip_tags($view['name']), 0, 30, 'utf-8')). '...')
@section('content')
    <div class="title-image-box"
         style="{!! !empty($view['thumbnail']) ? "background-image: url('".config('app.s3_thumb_url').$view['thumbnail']['file_path']."')" :  "background-image: url('".config('app.no_thumb_url')."')" !!}">
        <div class="inner text-white">
            <div class="cate">{{ $view['menu']['name'] ?? '-' }}</div>
            <p class="text-center text-4xl mt-2 line-clamp-2">{{ $view['name'] }}</p>
            <p class="text-right mt-2 line-clamp-1">{{ $view['created_at'] }}</p>
        </div>
    </div>
    <div class="inner my-5 py-5">
        <div class="toastui-editor-contents">
            {!! $view['content'] !!}
        </div>
        <ul class="tag-list">
            @foreach(json_decode($view['tag_list']) as $tag)
                <li><a href="/hash?hashtag={{ $tag }}">#{{ $tag }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
