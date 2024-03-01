@php
    $listArr = [
            'information' => [
                'name' => '기본정보관리',
                'menu' => [
                 ['name' => '블로그 정보', 'url' => route('information.index')],
                ]
            ],
            'menu' => [
                'name' => '메뉴관리',
                'menu' => [
                 ['name' => '메뉴관리', 'url' => route('menu.index')]
                ]
            ],
            'post' => [
                'name' => '글관리',
                'menu' => [
                 ['name' => '리스트', 'url' => route('post.index')],
                 ['name' => '글쓰기', 'url' => route('post.create')]
                ]
            ],
        ];
@endphp
<div class="left-wrap basis-[160px] py-5">
    <nav>
        <h3 class="sr-only">메뉴</h3>
        <div class="flex flex-col">
            <h4 class="font-bold mb-1">{{ $listArr[$path]['name'] }}</h4>
            <ul class="text-[0.825em]">
                @foreach($listArr[$path]['menu'] as $menu)
                    <li><a href="{{ $menu['url'] }}">{{ $menu['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>
