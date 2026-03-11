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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('tvc_url')->nullable()->after('content');
            $table->longText('challenge')->nullable()->after('tvc_url');
            $table->longText('solution')->nullable()->after('challenge');
            $table->json('gallery')->nullable()->after('solution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['tvc_url', 'challenge', 'solution', 'gallery']);
        });
    }
};
