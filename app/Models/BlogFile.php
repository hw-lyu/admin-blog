<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_path',
        'file_size',
        'file_name',
        'file_mine'
    ];
}
