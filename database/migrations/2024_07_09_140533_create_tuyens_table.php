<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuyens', function (Blueprint $table) {
            $table->id(); 
            $table->string('ten_tuyen');
            $table->unsignedBigInteger('id_don_vi'); 
            $table->timestamps();

            $table->foreign('id_don_vi')->references('id')->on('don_vis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuyens');
    }
};
