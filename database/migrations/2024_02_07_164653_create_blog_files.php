<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_path', 500)->comment('파일경로');
            $table->unsignedInteger('file_size')->comment('파일 사이즈');
            $table->string('file_name', 255)->comment('파일 이름');
            $table->string('file_mine', 255)->comment('확장자명');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_files');
    }
};
