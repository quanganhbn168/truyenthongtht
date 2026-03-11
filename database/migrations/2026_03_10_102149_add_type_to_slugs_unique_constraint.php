<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fix slug collision: đổi UNIQUE constraint từ (slug) → (slug, sluggable_type)
 *
 * Vấn đề: PostCategory "Dịch vụ TikTok" và ServiceCategory "Dịch vụ TikTok" có cùng slug
 * "dich-vu-tiktok.html" → INSERT vào bảng slugs sẽ bị UNIQUE constraint fail.
 *
 * Giải pháp: unique key bao gồm cả sluggable_type → cho phép cùng slug nhưng khác model type.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slugs', function (Blueprint $table) {
            // Xóa unique key cũ chỉ trên (slug)
            $table->dropUnique('slugs_slug_unique');

            // Thêm unique key mới trên (slug, sluggable_type)
            $table->unique(['slug', 'sluggable_type'], 'slugs_slug_type_unique');
        });
    }

    public function down(): void
    {
        Schema::table('slugs', function (Blueprint $table) {
            $table->dropUnique('slugs_slug_type_unique');
            $table->unique('slug', 'slugs_slug_unique');
        });
    }
};
