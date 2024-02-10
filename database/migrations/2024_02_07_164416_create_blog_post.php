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
        Schema::create('blog_post', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->comment('제목');
            $table->mediumText('content')->comment('글내용');
            $table->unsignedInteger('category_id')->comment('메뉴 아이디');
            $table->string('write', 50)->comment('글쓴이');
            $table->enum('is_blind', [0,1])->default(1)->comment('글 공개여부 0:비공개 1:공개');
            $table->json('tag_list')->comment('태그리스트');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post');
    }
};
