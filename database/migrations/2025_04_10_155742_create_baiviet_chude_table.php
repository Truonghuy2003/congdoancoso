<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baiviet_chude', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baiviet_id')->constrained('baiviet')->onDelete('cascade');
            $table->foreignId('chude_id')->constrained('chude')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baiviet_chude');
    }
};