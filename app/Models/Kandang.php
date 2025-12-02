<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kandang',
        'kapasitas',
        'jumlah_ayam',
        'keterangan',
    ];

    public function laporanHarians()
    {
        return $this->hasMany(LaporanHarian::class);
    }
}
