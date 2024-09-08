<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonVi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_don_vi',
        'ma_vung',
        'ten_don_vi',
        'ten_tat',
    ];

    public function tuyens()
    {
        return $this->hasMany(Tuyen::class, 'id_don_vi');
    }
}
