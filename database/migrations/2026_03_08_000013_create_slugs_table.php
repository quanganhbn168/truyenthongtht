<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 500)->unique()->index();
            $table->morphs('sluggable'); // sluggable_type + sluggable_id
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slugs');
    }
};
