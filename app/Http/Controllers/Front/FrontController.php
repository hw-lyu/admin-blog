<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogMenu;
use App\Models\BlogPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function __construct(public BlogPost $blogPost, public BlogComment $blogComment)
    {
    }

    /**
     * 메인 리스트
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('front.page.index');
    }

    /**
     * 보기 페이지
     *
     * @param string $menuEng
     * @param string $id
     * @return Application|Factory|View|FoundationApplication
     */
    public function show(string $menuEng, string $id): Application|Factory|View|FoundationApplication
    {
        if (!empty($menuEng)) {
            $menu = BlogMenu::where([
                'name_eng' => $menuEng,
                'is_blind' => 1
            ]);

            if (!$menu->exists()) {
                abort(404);
            }
        }

        $menuId = $menu->first()['id'];
        $view = $this->blogPost
            ->with(['menu', 'thumbnail', 'comment'])
            ->leftJoin('blog_menus', 'blog_post.menu_id', 'blog_menus.id')
            ->where([
                'blog_post.is_blind' => '1',
                'blog_menus.is_blind' => '1',
                'blog_post.menu_id' => $menuId
            ])
            ->selectRaw('blog_post.*')
            ->whereNull('blog_menus.deleted_at')
            ->findOrFail($id);

        $view->increment('view_count');

        return view('front.view', [
            'view' => $view,
            'postInfo' => [
                'menuId' => $menuId,
                'postId' => $id
            ]
        ]);
    }

    /**
     * 리스트 페이지
     *
     * @param string $menuEng
     * @return Application|Factory|View|FoundationApplication
     */
    public function menuPost(string $menuEng = ''): Application|Factory|View|FoundationApplication
    {
        $menu = [];

        if (!empty($menuEng)) {
            $menu = BlogMenu::where([
                'name_eng' => $menuEng,
                'is_blind' => 1
            ]);

            if (!$menu->exists()) {
                abort(404);
            }
        }

        $recentPostsData = $this->blogPost
            ->with(['menu', 'thumbnail'])
            ->leftJoin('blog_menus', 'blog_post.menu_id', 'blog_menus.id')
            ->when($menuEng, fn($query) => $query->where('menu_id', $menu->first()->id))
            ->where([
                'blog_post.is_blind' => 1,
                'blog_menus.is_blind' => 1
            ])
            ->whereNull('blog_menus.deleted_at')
            ->selectRaw('blog_post.id, blog_post.name, blog_post.content, blog_post.tag_list, blog_post.view_count, blog_post.is_blind, blog_post.menu_id, blog_post.thumbnail_id, blog_post.created_at')
            ->orderBy('blog_post.view_count', 'desc')
            ->limit(5);

        // If) post 글 생성 날짜가 7일 전보다 크거나 같을 경우 많이 본 게시글 기준으로 한다.
        // else) 7일 전보다 크거나 같은 게시물이 없는 경우 전체 글 기준으로 list data 생성
        $allDays = now()->addDays(-7);
        if ($this->blogPost->where('created_at', '>=', $allDays)->exists()) {
            $recentPostsList = $recentPostsData
                ->where('blog_post.created_at', '>=', $allDays)
                ->get()
                ->toArray();
        } else {
            $recentPostsList = $recentPostsData
                ->get()
                ->toArray();
        }

        return view('front.index', ['recentPostsList' => $recentPostsList]);
    }

    /**
     * 해시태그 리스트 페이지
     *
     * @param Request $request
     * @return Application|Factory|View|FoundationApplication
     */
    public function hashTag(Request $request): Application|Factory|View|FoundationApplication
    {
        $tagQuery = $request->query('hashtag');

        $tagList = BlogPost::with(['menu', 'thumbnail'])
            ->leftJoin('blog_menus', 'blog_post.menu_id', 'blog_menus.id')
            ->where([
                'blog_post.is_blind' => 1,
                'blog_menus.is_blind' => 1
            ])
            ->whereNull('blog_menus.deleted_at')
            ->whereJsonContains('tag_list', $tagQuery)
            ->selectRaw('blog_post.*')
            ->orderBy('id', 'desc');

        return view('front.hashtag', ['tagName' => $tagQuery, 'tagCount' => $tagList->count(), 'tagList' => $tagList->get()->toArray()]);
    }
}
