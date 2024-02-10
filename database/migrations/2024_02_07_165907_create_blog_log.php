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
        Schema::create('blog_log', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('이름');
            $table->string('page_url', 500)->comment('접속한 페이지');
            $table->unsignedInteger('ip')->comment('IPv4 값. 저장시 INET_ATON() / 조회시 INET_NTOA()를 씀.');
            $table->string('user_agent')->comment('유저 에이전트');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_log');
    }
};
