<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'no_meja',
        'status',
        'total_harga',
    ];
    public function items()
    {
        return $this->hasMany(ItemPesanan::class);
    }
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
