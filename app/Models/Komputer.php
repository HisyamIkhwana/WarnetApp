<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komputer extends Model
{
    use HasFactory;

    protected $fillable = [
        'warnet_id',
        'merk',
        'spesifikasi',
        'status', // Pastikan 'status' di sini adalah kolom boolean/enum di database Anda
    ];

    protected $table = 'komputers';

    /**
     * Relasi ke model Warnet.
     */
    public function warnet()
    {
        return $this->belongsTo(Warnet::class, 'warnet_id');
    }

    /**
     * Relasi ke semua sesi yang pernah ada di komputer ini.
     */
    public function sesis()
    {
        return $this->hasMany(Sesi::class, 'komputer_id');
    }

    /**
     * Relasi ke sesi yang sedang aktif saat ini.
     * Ini yang ditambahkan untuk memperbaiki error di controller.
     */
    public function sesiAktif()
    {
        return $this->hasOne(Sesi::class, 'komputer_id')->where('waktu_selesai', '>', now());
    }

    /**
     * Accessor untuk menentukan status komputer secara dinamis.
     * Kode ini tetap dipertahankan dari versi Anda.
     */
    public function getStatusAttribute()
    {
        // Jika status di database adalah 'nonaktif', langsung kembalikan 'nonaktif'
        if (isset($this->attributes['status']) && $this->attributes['status'] == 'nonaktif') {
            return 'nonaktif';
        }
        
        // Cek apakah ada sesi yang sedang aktif untuk komputer ini
        // Kita bisa menggunakan relasi yang baru kita buat
        if ($this->sesiAktif()->exists()) {
            return 'terpakai';
        }

        // Jika tidak ada kondisi di atas, berarti komputer tersedia
        return 'tersedia';
    }
}