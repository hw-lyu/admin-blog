<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogMenu;
use App\Models\BlogPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;

class FrontController extends Controller
{
    public function __construct(public BlogPost $blogPost)
    {
    }

    /**
     * 메인페이지
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('front.page.index');
    }

    /**
     * 디테일 페이지
     *
     * @param string $id
     * @return Application|Factory|View|FoundationApplication
     */
    public function show(string $id): Application|Factory|View|FoundationApplication
    {
        $view = $this->blogPost
            ->with(['menu', 'thumbnail'])
            ->where('is_blind', 1)
            ->findOrFail($id);

        $view->increment('view_count');

        return view('front.view', ['view' => $view]);
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

        $recentPostsList = $this->blogPost
            ->with(['menu', 'thumbnail'])
            ->leftJoin('blog_menus', 'blog_post.menu_id', 'blog_menus.id')
            ->when($menuEng, fn($query) => $query->where('menu_id', $menu->first()->id))
            ->where([
                'blog_post.is_blind' => 1,
                'blog_menus.is_blind' => 1
            ])
            ->selectRaw('blog_post.id, blog_post.name, blog_post.content, blog_post.tag_list, blog_post.view_count, blog_post.is_blind, blog_post.menu_id, blog_post.thumbnail_id, blog_post.created_at')
            ->orderBy('blog_post.view_count', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        return view('front.index', ['recentPostsList' => $recentPostsList]);
    }
}
