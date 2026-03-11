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
        Schema::table('services', function (Blueprint $table) {
            $table->longText('pain_points')->nullable()->after('content');
            $table->longText('benefits')->nullable()->after('pain_points');
            $table->longText('behind_the_scenes')->nullable()->after('benefits');
            $table->json('process')->nullable()->after('behind_the_scenes');
            $table->json('faq')->nullable()->after('process');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['pain_points', 'benefits', 'behind_the_scenes', 'process', 'faq']);
        });
    }
};
