<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'name_ko',
        'is_blind',
        'parent_id',
        'sort',
        'depth',
    ];
}
