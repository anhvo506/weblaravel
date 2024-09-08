<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kiem_tra_TBA', function (Blueprint $table) {
            $table->id();
            $table->dateTime('gio_kiem_tra');
            $table->text('hien_tuong_bat_thuong')->nullable();
            $table->text('ton_tai_da_xu_ly')->nullable();
            $table->text('bien_phap_de_nghi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiem_tra_TBA');
    }
};