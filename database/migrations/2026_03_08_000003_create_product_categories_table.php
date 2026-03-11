<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                     // danhmuc
            $table->string('slug', 200)->unique()->index();   // url
            $table->unsignedBigInteger('parent_id')->nullable(); // cha
            $table->text('description')->nullable();           // mota
            $table->longText('content')->nullable();           // theh
            $table->string('image', 1000)->nullable();
            $table->string('thumbnail', 1000)->nullable();
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('product_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
