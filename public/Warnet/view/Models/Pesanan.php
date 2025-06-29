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

    /**
     * Relasi ke item-item dalam pesanan.
     * Satu pesanan bisa memiliki banyak item.
     */
    public function items()
    {
        return $this->hasMany(ItemPesanan::class);
    }

    /**
     * Relasi ke transaksi.
     * Satu pesanan hanya memiliki satu transaksi.
     * INI YANG DITAMBAHKAN UNTUK MEMPERBAIKI ERROR
     */
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}