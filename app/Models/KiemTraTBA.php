<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiemTraTBA extends Model
{
    use HasFactory;

    protected $table = 'kiem_tra_TBA';

    protected $fillable = [
        'gio_kiem_tra',
        'hien_tuong_bat_thuong',
        'ton_tai_da_xu_ly',
        'bien_phap_de_nghi'
    ];

    public function tramBienAp()
    {
        return $this->hasMany(TramBienAp::class, 'id_kiem_tra');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'id_nhan_vien');
    }
}