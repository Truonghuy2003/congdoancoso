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
        Schema::create('luubaiviet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoidung_id')->constrained('nguoidung')->onDelete('cascade');
            $table->foreignId('baiviet_id')->constrained('baiviet')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luubaiviet');
    }
};
