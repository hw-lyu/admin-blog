@extends('front.layouts.default')
@section('og:title', '')
@section('og:description', '')
@section('og:url', Request()->url())
@section('title', '')
@section('content')
    <div class="inner">
        <div class="flex items-center p-3 bg-gray-400 mb-5 text-white">태그 : {{ $tagName }} <span
                class="text-sm ml-2 text-gray-100">{{$tagCount}}개 등록됨</span></div>
        <ul class="flex flex-col">
            @foreach($tagList as $list)
                <li class="{{ $loop->first ? '' : 'mt-7' }}">
                    <a href="{{ route('front.show', ['menuEng' => $list['menu']['name_eng'], 'id' => $list['id']]) }}" class="flex">
                        <div class="w-3/12 flex items-center">
                            <img src="{{!empty($list['thumbnail']['file_path']) ? config('app.s3_thumb_url').$list['thumbnail']['file_path'] : config('app.no_thumb_url')}}" alt="">
                        </div>
                        <div class="w-9/12 flex flex-col justify-center px-5 py-1">
                            <div class="menu pointer-events-none">{{ $list['menu']['name'] ?? '-' }}</div>
                            <div class="txt-box pointer-events-none">
                                <p class="text-2xl md:line-clamp-2 line-clamp-1 mt-1">{{ $list['name'] }}</p>
                                <p class="md:line-clamp-3 line-clamp-2 mt-1">{{ strip_tags($list['content']) }}</p>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
