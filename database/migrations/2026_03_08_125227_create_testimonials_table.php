<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Tên khách hàng
            $table->string('position')->nullable();        // Chức vụ / công ty
            $table->string('avatar')->nullable();          // Ảnh đại diện
            $table->text('content');                       // Nội dung nhận xét
            $table->unsignedTinyInteger('rating')->default(5); // Đánh giá 1-5
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
