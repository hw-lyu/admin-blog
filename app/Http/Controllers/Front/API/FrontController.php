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
            $menu = BlogMenu::where([
                'name_eng' => $menuEng,
                'is_blind' => 1
            ]);

            if (!$menu->exists()) {
                return response()->json(['error' => '메뉴명이 없습니다.']);
            }
        }

        $postList = $this->blogPost
            ->with(['menu', 'thumbnail'])
            ->leftJoin('blog_menus', 'blog_post.menu_id', 'blog_menus.id')
            ->when($menuEng, fn($query) => $query->where('menu_id', $menu->first()->id))
            ->where([
                'blog_post.is_blind' => 1,
                'blog_menus.is_blind' => 1
            ])
            ->whereNull('blog_menus.deleted_at')
            ->selectRaw('blog_post.id, blog_post.name, blog_post.content, blog_post.tag_list, blog_post.view_count, blog_post.is_blind, blog_post.menu_id, blog_post.thumbnail_id, blog_post.created_at')
            ->orderBy('blog_post.id', 'desc');

        return response()->json(['total' => $postList->count(), 'postList' => $postList->cursorPaginate(3)]);
    }
}
