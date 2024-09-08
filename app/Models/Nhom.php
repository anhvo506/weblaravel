<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nhom extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_nhom',
        'thu_tu_nhom',
        'id_doi',
    ];

    public function nhanViens()
    {
        return $this->hasMany(NhanVien::class, 'id_nhom');
    }

    public function doi()
    {
        return $this->belongsTo(Doi::class, 'id_doi');
    }
}
