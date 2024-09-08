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
        Schema::create('nhoms', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nhom');
            $table->integer('thu_tu_nhom');
            $table->unsignedBigInteger('id_doi');
            $table->foreign('id_doi')->references('id')->on('dois')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhoms');
    }
};