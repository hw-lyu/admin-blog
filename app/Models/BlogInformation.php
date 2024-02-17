<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogInformation extends Model
{
    protected $fillable = [
        'name',
        'nick_name',
        'introduce',
        'profile_img_path',
        'cover_img_path'
    ];
}
