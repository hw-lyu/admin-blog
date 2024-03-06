<header class="py-7">
    <div class="inner flex md:flex-row flex-col justify-between">
        <h1 class="text-4xl font-bold text-purple-700">
            <a href="/" class="flex flex-col">
                {{ $blogInfo['nick_name'] }}
                <span class="text-sm">{{ $blogInfo['name'] }}</span>
            </a>
        </h1>
        <nav class="flex items-center md:mt-0 mt-3">
            <ul class="flex flex-wrap">
                @foreach($blogMenu as $menu)
                    <li class="{{ !$loop->first ? 'ml-3' : ''}}"><a href="{{ route('front.page.index', ['menuEng' => $menu['name_eng']]) }}">{{ $menu['name'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
