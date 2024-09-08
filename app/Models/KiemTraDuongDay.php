<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiemTraDuongDay extends Model
{
    use HasFactory;
    protected $table = 'kiem_tra_dd';

    protected $fillable = [
        'gio_kiem_tra',
        'hien_tuong_bat_thuong',
        'ton_tai_da_xu_ly',
        'bien_phap_de_nghi',
    ];
    public function duongDayTrungThes()
    {
        return $this->hasMany(DuongDayTrungThe::class, 'id_kiem_tra');
    }
}
