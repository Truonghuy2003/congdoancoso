<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('file', function (Blueprint $table) {
            $table->string('ten_goc')->nullable()->after('loai_file'); // Thêm cột ten_goc sau loai_file
        });
    }

    public function down(): void
    {
        Schema::table('file', function (Blueprint $table) {
            $table->dropColumn('ten_goc');
        });
    }
};