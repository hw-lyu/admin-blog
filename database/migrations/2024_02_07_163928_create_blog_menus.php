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
        Schema::create('blog_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->comment('메뉴 한글명');
            $table->string('name_eng', 255)->nullable()->comment('메뉴 영문명');
            $table->tinyInteger('is_blind')->default(1)->comment('글 공개여부 0:비공개 1:공개');
            $table->unsignedInteger('parent_id')->nullable()->comment('부모 아이디 (첫뎁스일시 본인 아이디');
            $table->unsignedInteger('sort')->default(1)->comment('카테고리 순서');
            $table->unsignedInteger('depth')->default(1)->comment('뎁스 (최대 2뎁스)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_menus');
    }
};
