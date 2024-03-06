<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Models\BlogMenu;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;

class FrontController extends Controller
{
    public function __construct(public BlogPost $blogPost)
    {
    }

    /**
     * 리스트 페이지 API
     *
     * @param string $menuEng
     * @return JsonResponse
     */
    public function menuPost(string $menuEng = ''): JsonResponse
    {
        $menu = [];

        if (!empty($menuEng)) {
            $menu = BlogMenu::where('name_eng', $menuEng);

            if (!$menu->exists()) {
                return response()->json(['error' => '메뉴명이 없습니다.']);
            }
        }

        $postList = $this->blogPost
            ->with(['menu', 'thumbnail'])
            ->when($menuEng, fn($query) => $query->where('menu_id', $menu->first()->id))
            ->where('is_blind', 1)
            ->selectRaw('id, name, content, tag_list, view_count, menu_id, thumbnail_id, created_at')
            ->orderBy('id', 'desc')
            ->cursorPaginate(3);

        return response()->json(['postList' => $postList]);
    }
}
