<header>
    <div class="flex justify-between px-3 py-3 text-white bg-purple-600">
        <div class="flex items-center">
            <div class="flex items-baseline">
                <h1 class="common-title text-3xl mr-3 pr-3 uppercase"><a href="/">Lumii.</a></h1>
                <div>Admin</div>
            </div>
        </div>
        <nav class="flex items-center">
            <h2 class="sr-only">유용한 메뉴</h2>
            <ul class="flex items-center text-[0.825em]">
                <li class="pr-5"><a href="">내 블로그</a></li>
                <li><a href="">글쓰기</a></li>
            </ul>
        </nav>
    </div>
    <div class="flex px-3 py-2 border-y border-y-gray-200">
        <nav class="flex items-center">
            <h2 class="sr-only">메인 메뉴</h2>
            <ul class="flex items-center text-[0.825em]">
                <li class="pr-7"><a href="{{ route('information.index') }}">기본 설정</a></li>
                <li class="pr-7"><a href="{{ route('menu.index') }}">메뉴 관리</a></li>
                <li class="pr-7"><a href="">블로그 통계</a></li>
            </ul>
        </nav>
    </div>
</header>
