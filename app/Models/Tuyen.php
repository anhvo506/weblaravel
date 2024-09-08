<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuyen extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_tuyen',
        'id_don_vi'
    ];

    protected $table = 'tuyens';

    public function duongDayTrungThes()
    {
        return $this->hasMany(DuongDayTrungThe::class, 'tuyen_id');
    }

    public function tramBienAps()
    {
        return $this->hasMany(TramBienAp::class, 'tuyen_id');
    }

    public function donVi()
    {
        return $this->belongsTo(DonVi::class, 'id_don_vi');
    }
    
}
