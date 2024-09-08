<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'nhan_viens';

    protected $fillable = [
        'ten_nhan_vien',
        'ma_nhan_vien',
        'bo_phan',
        'chuc_danh',
        'bac_tho',
        'bac_AT',
        'id_user',
        'id_permission'
    ];

    // public function nhoms()
    // {
    //     return $this->hasMany(Nhom::class, 'id_nhom');
    // }
    public function nhom()
    {
        return $this->belongsTo(Nhom::class, 'id_nhom');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'id_permission', 'id');
    }
    
}
