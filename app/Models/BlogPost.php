<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'content',
        'menu_id',
        'write',
        'is_blind',
        'tag_list'
    ];
}
