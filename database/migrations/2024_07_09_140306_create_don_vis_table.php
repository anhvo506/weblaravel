<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_vis', function (Blueprint $table) {
            $table->id(); 
            $table->string('ma_don_vi');
            $table->integer('ma_vung');
            $table->string('ten_don_vi');
            $table->string('ten_tat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_vis');
    }
};
