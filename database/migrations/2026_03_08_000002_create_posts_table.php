<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);                     // ten
            $table->string('slug', 500)->unique()->index();    // url (giữ nguyên .html)
            $table->text('summary')->nullable();               // tomtat
            $table->foreignId('category_id')->nullable()       // danhmuc
                ->constrained('post_categories')->nullOnDelete();
            $table->string('image', 1000)->nullable();         // anh
            $table->string('thumbnail', 1000)->nullable();     // anh_thumb
            $table->longText('content')->nullable();            // chitiet
            $table->date('published_at')->nullable();           // ngaydang
            $table->unsignedInteger('view_count')->default(0);  // view
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->integer('sort_order')->default(0);          // ordernum
            $table->boolean('is_active')->default(true);        // status
            $table->string('tags', 1000)->nullable();           // tag
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
