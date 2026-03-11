<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()
                ->constrained('project_categories')->nullOnDelete();
            $table->string('name', 500);
            $table->string('slug', 500)->unique()->index();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('client_name', 200)->nullable();
            $table->date('project_date')->nullable();
            $table->string('image', 1000)->nullable();
            $table->string('thumbnail', 1000)->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
