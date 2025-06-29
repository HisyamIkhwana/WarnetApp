<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'jumlah_bayar',
        'metode_pembayaran',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}