<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Revert: đổi UNIQUE KEY từ (slug, sluggable_type) → chỉ (slug).
 *
 * Slug phải unique globally — một URL chỉ thuộc về đúng một model.
 * SlugObserver sẽ tự động append suffix nếu có conflict khi tạo mới.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slugs', function (Blueprint $table) {
            // Xóa composite unique key
            $table->dropUnique('slugs_slug_type_unique');

            // Khôi phục unique key chỉ trên slug
            $table->unique('slug', 'slugs_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->dropUnique('slugs_slug_unique');
            $table->unique(['slug', 'sluggable_type'], 'slugs_slug_type_unique');
        });
    }
};
