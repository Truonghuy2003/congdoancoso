<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banchaphanh', function (Blueprint $table) {
            // Xóa ràng buộc unique trên cột email
            $table->dropUnique(['email']); // Xóa ràng buộc unique hiện có
            $table->string('email')->change(); // Giữ cột email là string, không có unique
        });
    }

    public function down(): void
    {
        Schema::table('banchaphanh', function (Blueprint $table) {
            // Khôi phục ràng buộc unique nếu rollback
            $table->string('email')->unique()->change();
        });
    }
};