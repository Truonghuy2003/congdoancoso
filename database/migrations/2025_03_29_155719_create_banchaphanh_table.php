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
        Schema::create('banchaphanh', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten');
            $table->string('chuc_vu');
            $table->string('email')->unique();
            $table->string('dien_thoai')->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->text('nhiem_vu')->nullable();
            $table->string('nhiem_ky');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banchaphanh');
    }
};
