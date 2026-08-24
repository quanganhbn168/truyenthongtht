<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curator', function (Blueprint $table): void {
            $table->string('processing_format')->default('original')->after('ext');
            $table->boolean('watermark_enabled')->default(false)->after('processing_format');
            $table->unsignedTinyInteger('processing_quality')->default(90)->after('watermark_enabled');
            $table->string('original_path')->nullable()->after('processing_quality');
            $table->string('original_ext')->nullable()->after('original_path');
        });
    }

    public function down(): void
    {
        Schema::table('curator', function (Blueprint $table): void {
            $table->dropColumn([
                'processing_format',
                'watermark_enabled',
                'processing_quality',
                'original_path',
                'original_ext',
            ]);
        });
    }
};
