<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandang_id',
        'user_id',
        'tanggal',
        'jumlah_telur',
        'ayam_mati',
        'ayam_sakit',
        'pakan_kg',
        'suhu_kandang',
        'catatan',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
