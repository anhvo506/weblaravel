<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tram_bien_aps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tuyen_id');
            $table->string('ten_tram');
            $table->integer('dung_luong');
            $table->unsignedBigInteger('id_ddtt')->nullable(); // Khóa ngoại tham chiếu tới duong_day_trung_thes
            $table->unsignedBigInteger('id_nhan_vien')->nullable(); // Khóa ngoại tham chiếu tới nhan_viens
            $table->unsignedBigInteger('id_kiem_tra')->nullable(); // Khóa ngoại tham chiếu tới kiem_tra_TBA
            $table->unsignedBigInteger('id_nhom')->nullable(); 
            $table->timestamps();
            $table->foreign('tuyen_id')->references('id')->on('tuyens')->onDelete('cascade');
            $table->foreign('id_ddtt')->references('id')->on('duong_day_trung_thes')->onDelete('set null');
            $table->foreign('id_nhom')->references('id')->on('nhoms')->onDelete('set null');
            $table->foreign('id_kiem_tra')->references('id')->on('kiem_tra_TBA')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tram_bien_aps');
    }
};










