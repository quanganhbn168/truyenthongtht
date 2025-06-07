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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_category_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('banner')->nullable();
            $table->text('description')->nullable();
            $table->longText('content');
            $table->boolean('is_featured')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
