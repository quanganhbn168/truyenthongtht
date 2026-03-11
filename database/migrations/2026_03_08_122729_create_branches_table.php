<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Tên chi nhánh
            $table->string('address')->nullable();         // Địa chỉ
            $table->string('phone', 20)->nullable();       // Số điện thoại
            $table->string('email', 100)->nullable();      // Email liên hệ
            $table->string('map_url')->nullable();         // Google Maps embed URL
            $table->text('note')->nullable();              // Ghi chú
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_main')->default(false);   // Chi nhánh chính
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
