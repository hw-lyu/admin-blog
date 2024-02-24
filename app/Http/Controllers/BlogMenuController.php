<?php

namespace App\Http\Controllers;

use App\Models\BlogMenu;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BlogMenuController extends Controller
{

    public function __construct(public BlogMenu $blogMenu)
    {
    }

    /**
     * 기본세팅 메인 화면
     *
     * @return Application|Factory|View|FoundationApplication
     */
    public function index(): Application|Factory|View|FoundationApplication
    {
        $data = $this
            ->blogMenu
            ->selectRaw('id, name as blogMenu, name_eng as blogMenuEng, is_blind as postState, sort')
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray() ?? [
            'id' => '',
            'blogMenu' => '',
            'blogMenuEng' => '',
            'postState' => '',
            'sort' => '',
        ];

        return view('menu', ['data' => $data]);
    }

    /**
     * 메뉴 관리 리스트 저장
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->except(['_token']);

        $menuJson = json_decode($data['menu_data'], true);
        $removeMenuJson = json_decode($data['remove_menu_data'], true);
        $menuData = [];

        /*
         * 메뉴 로직
         *
         * 이전 메뉴 - 지금 현재 들어온 메뉴 sort 값 업데이트 다시 재갱신
         * menuJson에서 id가 있으면 sort 업데이트 id가 없으면 create, update
         */

        foreach ($menuJson as $key => $val) {
            // 클라이언트 데이터 쿼리 필드명에 맞게 재가공
            $menuData[$key]['name'] = $val['blogMenu'];
            $menuData[$key]['name_eng'] = $val['blogMenuEng'];
            $menuData[$key]['is_blind'] = $val['postState'];
            $menuData[$key]['sort'] = $val['sort'];

            if (empty($val['id'])) {
                // 아이디가 없으면 메뉴 생성 및 sort 값 그대로 받아오기
                $menu = $this->blogMenu
                    ->create($menuData[$key]);

                $menu->where('id', $menu->id)
                    ->update(['parent_id' => $menu->id, 'sort' => $menuData[$key]['sort']]);
            } else {
                // 아이디가 있으면 sort 값만 재갱신
                $this->blogMenu
                    ->where('id', $val['id'])
                    ->update($menuData[$key]);
            }
        }

        /**
         * 메뉴 삭제 로직
         *
         * 소프트 딜리트
         */
        foreach ($removeMenuJson as $removeMenu) {
            $this->blogMenu
                ->where('id', $removeMenu['id'])
                ->delete();
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }
}
