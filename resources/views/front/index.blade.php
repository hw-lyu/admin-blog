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
                            <div class="text-sm absolute top-3 right-3">조회수 {{ $recentPostList['view_count'] ?? '-' }}</div>
                            <div class="menu pointer-events-none">{{ $recentPostList['menu']['name'] ?? '-' }}</div>
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
        const postList = document.querySelector('.post-list');
        const PATH = `/api/v1${location.pathname}?cursor=`;

        const items = async function (nextCursor = '') {
            fetch(`${PATH}${nextCursor}`, {
                method: 'get'
            }).then(function (response) {
                return response.json();
            }).then(function (response) {
                let list = response?.postList;

                if(!list.data.length) {
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
                                    <div class="menu">${ele['menu']['name'] ?? '-'}</div>
                                    <div class="group">
                                        <p class="text-2xl md:line-clamp-2 line-clamp-1">${ele['name']}</p>
                                        <p class="info md:line-clamp-5 line-clamp-3">${divHidden.innerText}</p>
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
                                    items(postList.next_cursor);
                                } else {
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
