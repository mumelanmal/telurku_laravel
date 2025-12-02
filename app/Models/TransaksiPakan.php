<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'stok_pakan_id',
        'user_id',
        'tipe',
        'jumlah_kg',
        'keterangan',
    ];

    public function stokPakan()
    {
        return $this->belongsTo(StokPakan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
