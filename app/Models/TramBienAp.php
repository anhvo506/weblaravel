<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramBienAp extends Model
{
    use HasFactory;

    protected $table = 'tram_bien_aps';

    protected $fillable = [
        'tuyen_id',
        'ten_tram',
        'dung_luong',
        'id_ddtt',
        'id_nhom', 
        'id_kiem_tra'
    ];

    public function tuyen()
    {
        return $this->belongsTo(Tuyen::class, 'tuyen_id');
    }

    public function duongDayTrungThe()
    {
        return $this->belongsTo(DuongDayTrungThe::class, 'id_ddtt');
    }
    public function group()
    {
        return $this->belongsTo(Nhom::class, 'id_nhom'); // Giả sử 'id_nhom' là khóa ngoại
    }
    

    public function kiemTraTBA()
    {
        return $this->belongsTo(KiemTraTBA::class, 'id_kiem_tra');
    }
}