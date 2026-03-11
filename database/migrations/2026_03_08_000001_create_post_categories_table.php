<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                    // danhmuc
            $table->string('slug', 200)->unique()->index();  // url (giữ nguyên .html)
            $table->unsignedBigInteger('parent_id')->nullable(); // cha
            $table->text('description')->nullable();          // mota
            $table->boolean('show_home')->default(false);     // home
            $table->boolean('show_home2')->default(false);    // home2
            $table->boolean('show_menu')->default(false);     // menu
            $table->boolean('show_footer')->default(false);   // foot
            $table->string('image', 1000)->nullable();        // anh
            $table->string('thumbnail', 1000)->nullable();    // anh_thumb
            $table->unsignedInteger('view_count')->default(0); // view
            $table->longText('content')->nullable();           // theh (nội dung HTML)
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable(); // meta_des
            $table->string('keywords', 500)->nullable();      // keyword
            $table->integer('sort_order')->default(0);        // ordernum
            $table->boolean('is_active')->default(true);      // status (0=active, 1=inactive in old DB)
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('post_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
