<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogInformation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nick_name',
        'introduce',
        'profile_img_path',
        'cover_img_path'
    ];
}
