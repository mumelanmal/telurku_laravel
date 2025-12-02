<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokPakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pakan',
        'stok_kg',
        'harga_per_kg',
    ];

    public function transaksiPakans()
    {
        return $this->hasMany(TransaksiPakan::class);
    }
}
