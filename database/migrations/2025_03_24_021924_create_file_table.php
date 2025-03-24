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
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baiviet_id')->nullable()->constrained('baiviet')->onDelete('cascade'); // Liên kết tùy chọn với bài viết
            $table->foreignId('nguoidung_id')->constrained('nguoidung')->onDelete('cascade'); // Người upload
            $table->string('duong_dan_file'); // Đường dẫn file
            $table->string('loai_file'); // Loại file (image, pdf, v.v.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file');
    }
};
