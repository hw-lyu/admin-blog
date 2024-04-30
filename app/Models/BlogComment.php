<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'password',
        'content',
        'menu_id',
        'post_id',
        'ip',
        'user_agent',
        'comment_file_id'
    ];

    // 코멘트 파일, 포스트, 메뉴 아이디
    public function commentFile(): HasOne
    {
        return $this->hasOne(BlogFile::class, 'id', 'comment_file_id');
    }
}
