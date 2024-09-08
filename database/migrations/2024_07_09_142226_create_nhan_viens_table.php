<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nhan_vien');
            $table->string('ma_nhan_vien');
            $table->string('bo_phan');
            $table->string('chuc_danh');
            $table->string('bac_tho');
            $table->string('bac_AT');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_permission')->nullable();
            $table->timestamps();
        
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_permission')->references('id')->on('permissions')->onDelete('set null');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
