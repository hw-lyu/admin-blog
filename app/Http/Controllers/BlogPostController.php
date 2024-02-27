<?php

namespace App\Http\Controllers;

use App\Models\BlogMenu;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function __construct(public BlogPost $blogPost, public BlogMenu $blogMenu)
    {
    }

    public function create()
    {
        $menus = $this
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

        return view('write', ['menus' => $menus]);
    }
}
