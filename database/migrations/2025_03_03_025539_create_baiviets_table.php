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
        Schema::create('baiviet', function (Blueprint $table) {
            Schema::create('baiviet', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chude_id')->constrained('chude')->onDelete('cascade');
                $table->foreignId('nguoidung_id')->constrained('nguoidung')->onDelete('cascade');
                $table->string('tieude', 255);
                $table->string('tieude_slug', 255)->unique();
                $table->text('tomtat')->nullable();
                $table->longText('noidung'); // Nội dung dài nên dùng longText
                $table->unsignedInteger('luotxem')->default(0);
                $table->boolean('kiemduyet')->default(1);
                $table->boolean('kichhoat')->default(1);
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baiviet');
    }
};
