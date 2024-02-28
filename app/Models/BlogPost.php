<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $table = 'blog_post';

    protected $fillable = [
        'name',
        'content',
        'menu_id',
        'write',
        'is_blind',
        'tag_list'
    ];

    /**
     * 글의 메뉴아이디 - 메뉴의 아이디 매칭 (1:1)
     *
     * @return HasOne
     */
    public function menu() : HasOne {
        return $this->hasOne(BlogMenu::class, 'id', 'menu_id');
    }
}
