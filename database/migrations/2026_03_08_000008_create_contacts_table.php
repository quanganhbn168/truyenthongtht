<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('email', 200)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('subject', 500)->nullable();    // tieude
            $table->text('message')->nullable();            // noidung
            $table->boolean('is_read')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
