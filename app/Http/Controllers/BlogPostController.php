<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogMenu;
use App\Models\BlogPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function __construct(public BlogPost $blogPost, public BlogMenu $blogMenu)
    {
    }

    /**
     * 메인화면 - 글 리스트
     *
     * @return Application|Factory|View|FoundationApplication
     */
    public function index(): Application|Factory|View|FoundationApplication
    {
        $post = $this->blogPost
            ->with(['menu'])
            ->paginate(5) ?? [
            [
                'id' => 0,
                'name' => '',
                'tag_list' => json_encode(['']),
                'menu' => [
                    'name' => '',
                    'name_eng' => ''
                ]
            ]
        ];


        return view('post-list', ['post' => $post]);
    }

    /**
     * 글보기 페이지
     *
     * @param string $id
     * @return Application|Factory|View|FoundationApplication
     */
    public function show(string $id): Application|Factory|View|FoundationApplication
    {
        $post = $this->blogPost
            ->with(['menu'])
            ->find($id) ?? [
            'id' => 0,
            'name' => '',
            'tag_list' => json_encode(['']),
            'menu' => [
                'name' => '',
                'name_eng' => ''
            ]
        ];

        return view('post-view', ['post' => $post]);
    }

    /**
     * 글쓰기 페이지
     *
     * @return Application|Factory|View|FoundationApplication
     */
    public function create(): Application|Factory|View|FoundationApplication
    {
        $menus = $this
            ->blogMenu
            ->selectRaw('id, name as blogMenu, name_eng as blogMenuEng, is_blind as postState, sort')
            ->where('is_blind', 1)
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray() ?? [
            [
                'id' => '',
                'blogMenu' => '',
                'blogMenuEng' => '',
                'postState' => '',
                'sort' => '',
            ]
        ];

        return view('post-write', ['menus' => $menus]);
    }

    /**
     *  글등록
     *
     * @param BlogPostRequest $request
     * @return RedirectResponse
     */
    public function store(BlogPostRequest $request): RedirectResponse
    {
        $post = $request->except('_token');
        $tagListJsonData = json_encode(explode('|', $post['tag_list']));

        try {
            $this->blogPost->create([
                'name' => $post['name'],
                'content' => $post['content'],
                'menu_id' => $post['menu_id'],
                'write' => $request->user()['email'],
                'tag_list' => $tagListJsonData,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with(['message' => '등록이 완료되었습니다.']);
    }

    /**
     * 글 업데이트
     *
     * @param string $id
     * @param BlogPostRequest $request
     * @return RedirectResponse
     */
    public function update(string $id, BlogPostRequest $request): RedirectResponse
    {
        $post = $request->except('_token');
        $tagListJsonData = json_encode(explode('|', $post['tag_list']));

        try {
            $this->blogPost
                ->with(['menu'])
                ->find($id)
                ->update([
                    'name' => $post['name'],
                    'content' => $post['content'],
                    'menu_id' => $post['menu_id'],
                    'write' => $request->user()['email'],
                    'tag_list' => $tagListJsonData,
                ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('post.edit', ['post' => $id])->with(['message' => '수정이 완료했습니다.']);
    }

    /**
     * 글 수정
     *
     * @param string $id
     * @return Application|Factory|View|FoundationApplication
     */
    public function edit(string $id): Application|Factory|View|FoundationApplication
    {
        $post = $this->blogPost
            ->with(['menu'])
            ->find($id) ?? [
            'id' => 0,
            'name' => '',
            'tag_list' => json_encode(['']),
            'menu' => [
                'name' => '',
                'name_eng' => ''
            ]
        ];

        $menus = $this
            ->blogMenu
            ->selectRaw('id, name as blogMenu, name_eng as blogMenuEng, is_blind as postState, sort')
            ->where('is_blind', 1)
            ->orderBy('sort', 'asc')
            ->get()
            ->toArray() ?? [
            [
                'id' => '',
                'blogMenu' => '',
                'blogMenuEng' => '',
                'postState' => '',
                'sort' => '',
            ]
        ];

        return view('post-edit', ['post' => $post, 'menus' => $menus]);
    }

    /**
     * 글 삭제
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->blogPost
                ->where('id', $id)
                ->delete();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('post.index')->with(['message' => '삭제가 완료했습니다.']);
    }
}
