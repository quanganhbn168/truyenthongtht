<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intros', function (Blueprint $table): void {
            $table->string('kind')->default('block')->index();
            $table->string('slug')->nullable()->unique();
            $table->text('summary')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamp('published_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('intros', fn (Blueprint $table) => $table->dropColumn(['kind', 'slug', 'summary', 'meta_title', 'meta_description', 'keywords', 'published_at']));
    }
};
