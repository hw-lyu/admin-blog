<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
