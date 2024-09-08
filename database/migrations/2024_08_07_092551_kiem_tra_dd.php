<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKiemTraDuongDayTable extends Migration
{
    public function up()
    {
        Schema::create('kiem_tra_duong_day', function (Blueprint $table) {
            $table->id(); // Tạo trường id tự động tăng
          
            $table->dateTime('gio_kiem_tra'); // Trường để lưu giờ kiểm tra
            $table->text('hien_tuong_bat_thuong')->nullable(); // Trường để lưu hiện tượng bất thường
            $table->boolean('ton_tai_da_xu_ly'); // Trường để lưu tình trạng xử lý
            $table->text('bien_phap_de_nghi')->nullable(); // Trường để lưu biện pháp đề nghị
            $table->timestamps(); // Trường created_at và updated_at

            // Khóa ngoại để liên kết với bảng duong_day_trung_the
            $table->foreign('duong_day_id')->references('id')->on('duong_day_trung_the')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kiem_tra_duong_day');
    }
}
