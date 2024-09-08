<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuongDayTrungThe extends Model
{
    protected $fillable = [
        'tuyen_id',
        'ten_duong_day',
        'tu_vi_tri_tru',
        'den_vi_tri_tru',
        'chieu_dai',
    ];
    protected $table = 'duong_day_trung_thes';

    public function tuyen()
    {
        return $this->belongsTo(Tuyen::class, 'tuyen_id');
    }
    public function tramBienAps()
    {
        return $this->hasMany(TramBienAp::class, 'id_ddtt');
    }
    public function kiemTraDuongDay()
    {
        return $this->belongsTo(KiemTraDuongDay::class, 'id_kiem_tra');
    }
   
}