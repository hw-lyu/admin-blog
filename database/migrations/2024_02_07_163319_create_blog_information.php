<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_information', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('블로그명');
            $table->string('nick_name', 10)->comment('별명');
            $table->string('introduce', 200)->comment('자기소개');
            $table->string('profile_img_path', 255)->nullable()->comment('프로필 이미지 경로');
            $table->string('cover_img_path', 255)->nullable()->comment('커버 이미지 경로');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_information');
    }
};
