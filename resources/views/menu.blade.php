@extends('layouts.default')
@section('right-content')
    <form action="{{ route('information.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex">
            <nav class="basis-[250px]">
                <div class="flex mb-3 text-sm">
                    <button type="button" id="blogMenuAdd" class="mr-3">추가</button>
                    <button type="button" id="blogMenuRemove">삭제</button>
                </div>
                <ul class="flex flex-col list border-double border-4 border-black py-2">
                    <li>
                        <button type="button" class="first-node w-full text-left py-1 px-3" draggable="true">메뉴1
                        </button>
                    </li>
                    <li>
                        <button type="button" class="first-node w-full text-left py-1 px-3" draggable="true">메뉴2
                        </button>
                    </li>
                    <li>
                        <button type="button" class="first-node w-full text-left py-1 px-3" draggable="true">메뉴3
                        </button>
                    </li>
                    <li>
                        <button type="button" class="first-node w-full text-left py-1 px-3" draggable="true">메뉴4
                        </button>
                    </li>
                </ul>
            </nav>
            <div class="basis-[calc(100%-250px)] pl-10 mt-[32px]">
                <table class="w-full table-fixed text-left">
                    <colgroup>
                        <col style="width:100px;">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th><label for="blogMenu">메뉴명</label></th>
                        <td><input type="text" id="blogMenu" class="w-full form-input" name="menu"></td>
                    </tr>
                    <tr>
                        <th><label for="blogMenuEng">메뉴 영문명</label></th>
                        <td><input type="text" id="blogMenuEng" class="w-full form-input" name="menu_en"></td>
                    </tr>
                    <tr>
                        <th>공개설정</th>
                        <td>
                            <label><input type="radio" name="post_state" value="false">공개</label>
                            <label><input type="radio" name="post_state" value="true">비공개</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center mt-2">
            <button type="submit" class="py-2 px-5 rounded-md text-white bg-purple-500">등록</button>
        </div>
    </form>

    <script>
        let list = document.querySelector('.list'),
            items = [...list.querySelectorAll('li')],
            dragObj = {},
            inputData = {};

        // 메뉴 드래그 관련 이벤트
        list.addEventListener('dragstart', function (e) {
            let eTarget = e.target;

            if (eTarget.tagName === 'BUTTON') {
                dragObj.start = {
                    idx: items.findIndex(ele => {
                        return ele === eTarget.parentElement
                    }),
                    ele: eTarget.parentElement
                };
            }
        });

        list.addEventListener('dragleave', function (e) {
            let eTarget = e.target;

            if (eTarget.tagName === 'BUTTON') {
                dragObj.leave = {
                    idx: items.findIndex(ele => {
                        return ele === eTarget.parentElement
                    }),
                    ele: eTarget.parentElement
                };
            }
        });

        list.addEventListener('dragend', function () {
            items[dragObj.start.idx] = dragObj.leave.ele;
            items[dragObj.leave.idx] = dragObj.start.ele;

            list.append(...items);
        });

        // 클릭시 메뉴 액티브 이벤트
        list.addEventListener('click', function (e) {
            let eTarget = e.target;

            [...document.querySelectorAll('.list li')].map(ele => {
                ele.querySelector('button').classList.remove('bg-gray-200');
            });

            if (eTarget.tagName === 'BUTTON') {

                // 현재 클릭기준 버튼 기준 추가
                dragObj.nowBtn = {
                    ele: eTarget.parentElement
                };

                eTarget.classList.add('bg-gray-200');
            }
        });

        document.getElementById('blogMenuAdd').addEventListener('click', function (e) {
            let eTarget = e.target,
                item = document.createElement('li'),
                btn = document.createElement('button');

            // 현재 인풋 데이터
            inputData = {
                blogMenu: document.getElementById('blogMenu'),
                blogMenuEng: document.getElementById('blogMenuEng'),
                postState: document.querySelector('input[name="post_state"]:checked')
            };

            btn.type = "button";
            btn.className = "first-node w-full text-left py-1 px-3";
            btn.draggable = true;
            btn.textContent = inputData.blogMenu.value;

            // li에서 현재 액티브된 클래스 유무 판별하는 상태값
            let btnClassState = [...eTarget.closest('nav').querySelectorAll('.list li')].filter(function (ele) {
                return ele.querySelector('button').classList.contains('bg-gray-200');
            });

            // 해당 값이 있으면 해당 엘리먼트 바로 밑에 추가, 없으면 맨 끝에 추가
            if (btnClassState.length) {
                [...document.querySelectorAll('.list li')].map(ele => {
                    if (ele.querySelector('button').classList.contains('bg-gray-200')) {
                        ele.after(item);
                        item.appendChild(btn);
                    }
                });
            } else {
                let lastItem = document.querySelector('.list li:last-of-type');

                if(lastItem === null) {
                    list.appendChild(item);
                } else {
                    document.querySelector('.list li:last-of-type').after(item);
                }

                item.appendChild(btn);
            }

            // items 상태 업데이트
            items = [...document.querySelectorAll('.list li')];
        });

        // 메뉴 삭제시
        document.getElementById('blogMenuRemove').addEventListener('click', function () {
            items = items.filter((ele) => {
                if (ele === dragObj.nowBtn.ele) {
                    ele.remove();
                }
                return ele !== dragObj.nowBtn.ele
            });
        });
    </script>

@endsection
