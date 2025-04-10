<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baiviet', function (Blueprint $table) {
            $table->dropForeign(['chude_id']); // Xóa khóa ngoại
            $table->dropColumn('chude_id');    // Xóa cột
        });
    }

    public function down(): void
    {
        Schema::table('baiviet', function (Blueprint $table) {
            $table->foreignId('chude_id')->constrained('chude')->onDelete('cascade');
        });
    }
};