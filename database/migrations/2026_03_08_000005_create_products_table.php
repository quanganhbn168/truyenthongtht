<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()
                ->constrained('product_categories')->nullOnDelete();
            $table->string('name', 500);                       // ten
            $table->string('slug', 500)->unique()->index();     // url
            $table->text('summary')->nullable();                // mota
            $table->longText('content')->nullable();             // chitiet
            $table->decimal('original_price', 15, 0)->default(0); // giagoc
            $table->decimal('price', 15, 0)->default(0);        // gia
            $table->string('image', 1000)->nullable();
            $table->string('thumbnail', 1000)->nullable();
            $table->date('published_at')->nullable();            // ngaydang
            $table->boolean('is_bestseller')->default(false);    // banchay
            $table->unsignedInteger('view_count')->default(0);
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('tags', 1000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
