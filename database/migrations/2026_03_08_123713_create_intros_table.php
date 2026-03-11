<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intros', function (Blueprint $table) {
            $table->id();
            $table->string('title');                      // Tiêu đề / tên mục
            $table->string('subtitle')->nullable();       // Tiêu đề phụ
            $table->string('icon', 100)->nullable();      // Icon class (fa-solid fa-...) hoặc tên
            $table->string('image')->nullable();          // Hình ảnh minh hoạ
            $table->text('content')->nullable();          // Mô tả / nội dung
            $table->string('link')->nullable();           // Liên kết (nếu có)
            $table->string('link_text', 100)->nullable(); // Text của nút/link
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intros');
    }
};
