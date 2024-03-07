<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'blog_post';

    protected $fillable = [
        'name',
        'content',
        'menu_id',
        'write',
        'is_blind',
        'view_count',
        'tag_list',
        'thumbnail_id'
    ];

    /**
     * array / JSON 직렬화 날짜를 해당 포맷으로 준비
     */
    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * 글의 메뉴아이디 - 메뉴의 아이디 매칭 (1:1)
     *
     * @return HasOne
     */
    public function menu(): HasOne
    {
        return $this->hasOne(BlogMenu::class, 'id', 'menu_id');
    }

    /**
     * 글의 썸네일 이미지 - 파일의 아이디 매칭 (1:1)
     *
     * @return HasOne
     */
    public function thumbnail(): HasOne
    {
        return $this->hasOne(BlogFile::class, 'id', 'thumbnail_id');
    }
}
