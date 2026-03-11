<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 200)->unique()->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image', 1000)->nullable();
            $table->string('thumbnail', 1000)->nullable();
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('project_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_categories');
    }
};
