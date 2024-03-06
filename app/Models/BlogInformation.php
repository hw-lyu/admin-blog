<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'nick_name',
        'introduce',
        'profile_file_id',
        'cover_file_id'
    ];

    /**
     * 인포메이션 profile_file_id - 파일로그의 메타정보 매칭 (1:1)
     *
     * @return HasOne
     */
    public function profileFile() : HasOne {
        return $this->hasOne(BlogFile::class, 'id', 'profile_file_id');
    }

    /**
     * 인포메이션 cover_file_id - 파일로그의 메타정보 매칭 (1:1)
     *
     * @return HasOne
     */
    public function coverFile() : HasOne {
        return $this->hasOne(BlogFile::class, 'id', 'cover_file_id');
    }
}
