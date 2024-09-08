<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duong_day_trung_thes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tuyen_id');
            $table->string('ten_duong_day');
            $table->string('tu_vi_tri_tru');
            $table->string('den_vi_tri_tru');
            $table->integer('chieu_dai');
            $table->foreign('tuyen_id')->references('id')->on('tuyens')->onDelete('cascade');
            $table->unsignedBigInteger('id_kiem_tra')->nullable(); // Khóa ngoại tham chiếu tới kiem_tra_TBA
            $table->foreign('id_kiem_tra')->references('id')->on('kiem_tra_dd')->onDelete('set null');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duong_day_trung_thes');
    }
};
