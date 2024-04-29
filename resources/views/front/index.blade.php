@extends('front.layouts.default')
@section('title', '메인')
@section('content')
    <div class="inner flex flex-col">
        <h2 class="pt-5 pb-2">💡 많이 본 게시글 💡</h2>
        <div class="overflow-y-hidden overflow-y-auto">
            <ul class="recent-posts-list">
                @if(empty($recentPostsList))
                    <li class='mt-1'>리스트 데이터가 없습니다 :)</li>
                @endif
                @foreach($recentPostsList as $recentPostList)
                    <li class="item {{ $loop->first ? 'active' : '' }}"
                        style="{!! !empty($recentPostList['thumbnail']) ? "background-image: url('".config('app.s3_thumb_url').$recentPostList['thumbnail']['file_path']."')" : "background-image: url('".config('app.no_thumb_url')."')" !!}">
                        <a href="{{ route('front.show', ['menuEng' => $recentPostList['menu']['name_eng'], 'id' => $recentPostList['id']]) }}">
                            <div class="text-sm absolute top-3 right-3">
                                조회수 {{ $recentPostList['view_count'] ?? '-' }}</div>
                            <div
                                class="font-medium	menu pointer-events-none">{{ $recentPostList['menu']['name'] ?? '-' }}</div>
                            <div class="txt-box pointer-events-none">
                                <p class="text-2xl md:line-clamp-2 line-clamp-1 mt-1">{{ $recentPostList['name'] }}</p>
                                <p class="md:line-clamp-3 line-clamp-2 mt-1">{{ strip_tags($recentPostList['content']) }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="inner flex flex-col">
        <h2 class="pt-10 pb-2">🏷 최근 글 리스트 🏷️</h2>
        <ul class="post-list flex flex-col"></ul>
        <div role="status" class="spin justify-center hidden">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script>
        let recentPostsList = document.querySelector('.recent-posts-list');

        function recentPostEvent(e) {
            let eTarget = e.target;

            if (eTarget.tagName === 'A') {
                [...recentPostsList.querySelectorAll('li')].map(ele => {
                    if (ele.classList.contains('active')) {
                        ele.classList.remove('active');
                    }
                    eTarget.parentElement.classList.add('active');
                });
            }
        }

        recentPostsList.addEventListener('mouseover', recentPostEvent);
        recentPostsList.addEventListener('touchend', recentPostEvent);

        // 리스트 - 무한 스크롤
        let spin = document.querySelector('.spin');
        const postList = document.querySelector('.post-list');
        const PATH = `/api/v1${location.pathname}?cursor=`;

        const items = function (nextCursor = '') {
            fetch(`${PATH}${nextCursor}`, {
                method: 'get'
            }).then(function (response) {
                return response.json();
            }).then(function (response) {
                let list = response?.postList;;

                if (!list.data.length) {
                    return postList.innerHTML = "<li class='mt-1'>리스트 데이터가 없습니다 :)</li>"
                }

                list.data.map(ele => {
                    let item = document.createElement('li'),
                        divHidden = document.createElement('div');
                    divHidden.className = "hidden";
                    divHidden.innerHTML = ele['content'];

                    item.className = 'item';
                    item.innerHTML = `
                            <a href="/view/${ele['menu']['name_eng']}/${ele['id']}">
                                <div class="img">
                                     ${ele['thumbnail'] ? `<img src="{{config('app.s3_thumb_url')}}${ele['thumbnail']['file_path']}" alt="">` : `<img src="{{config('app.no_thumb_url')}}" alt="">`}
                                </div>
                                <div class="txt-box">
                                    <div class="menu mb-1">${ele['menu']['name'] ?? '-'}</div>
                                    <div class="group">
                                        <p class="font-medium text-2xl md:line-clamp-2 line-clamp-1">${ele['name']}</p>
                                        <p class="info line-clamp-3">${divHidden.innerText}</p>
                                    </div>
                                    <p class="date">${ele['created_at']}</p>
                                </div>
                            </a>
                        `;

                    postList.appendChild(item);
                });

                return response;
            }).then(function (response) {
                const postList = response.postList;
                const postListItem = document.querySelector('.post-list li:last-of-type');

                if (postListItem) {
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            // 주시 대상이 뷰포트 안으로 들어오면
                            if (entry.intersectionRatio > 0) {
                                if (postList.next_cursor?.length && (response.total !== [...document.querySelectorAll('.post-list li')].length)) {
                                    spin.classList.remove('hidden');
                                    spin.classList.add('flex');
                                    setTimeout(function() {
                                        items(postList.next_cursor)
                                    }, 300);
                                } else {
                                    spin.classList.remove('flex');
                                    spin.classList.add('hidden');
                                    console.log('마지막글 완료 :)');
                                }
                            }
                        });
                    });

                    io.observe(postListItem);
                }
            });
        };

        items();
    </script>
@endsection
