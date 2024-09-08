<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_doi',
        'ten_doi',
    ];

    public function nhoms()
    {
        return $this->hasMany(Nhom::class, 'id_doi');
    }
}
