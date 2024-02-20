@extends('layouts.default')
@section('right-content')
    <form action="{{ route('information.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex">
            <nav class="basis-[250px] border border-black py-3">
                <ul class="list">
                    <li>
                        <button type="button" draggable="true">메뉴1</button>
                    </li>
                    <li>
                        <button type="button" draggable="true">메뉴2</button>
                    </li>
                    <li>
                        <button type="button" draggable="true">메뉴3</button>
                    </li>
                    <li>
                        <button type="button" draggable="true">메뉴4</button>
                    </li>
                </ul>
            </nav>
            <div class="basis-[calc(100%-250px)] pl-10">
                <div class="flex justify-between mb-3 text-sm">
                    <div class="flex">
                        <button type="button" class="mr-2" id="cateAdd">카테고리 추가</button>
                        <button type="button">구분선 추가</button>
                    </div>
                    <button type="button">삭제</button>
                </div>
                <table class="w-full table-fixed text-left">
                    <colgroup>
                        <col style="width:100px;">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th><label for="blogCategory">카테고리명</label></th>
                        <td><input type="text" id="blogCategory" class="w-full form-input" name="category"></td>
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
            item = [...list.querySelectorAll('li')],
            dragObj = {};

        list.addEventListener('dragstart', function (e) {
            let eTarget = e.target;

            if (eTarget.tagName === 'BUTTON') {
                dragObj.start = {
                    idx: item.findIndex(ele => {
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
                    idx: item.findIndex(ele => {
                        return ele === eTarget.parentElement
                    }),
                    ele: eTarget.parentElement
                };
            }
        });

        list.addEventListener('dragend', function () {
            item[dragObj.start.idx] = dragObj.leave.ele;
            item[dragObj.leave.idx] = dragObj.start.ele;

            list.append(...item);
        });


        list.addEventListener('click', function (e) {
            let eTarget = e.target;

            if (eTarget.tagName === 'BUTTON') {
                console.log(eTarget);
            }
        });

        // document.getElementById('cateAdd').addEventListener('click', function() {
        //     let item = document.createElement('li'),
        //         btn = document.createElement('button');
        //
        //     list.appendChild(item);
        //     item.appendChild(btn);
        // });
    </script>

@endsection
