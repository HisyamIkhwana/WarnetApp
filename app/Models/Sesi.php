<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesis'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    public $timestamps = true; // Timestamps (created_at dan updated_at)

    // Definisikan kolom yang dapat diisi secara massal
    protected $fillable = [
        'komputer_id',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
    ];

    // Cast waktu_mulai and waktu_selesai to datetime
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi dengan tabel komputer (one-to-one)
    public function komputer()
    {
        return $this->belongsTo(Komputer::class, 'komputer_id');
    }

    // Mutator untuk waktu_mulai
    public function setWaktuMulaiAttribute($value)
    {
        $this->attributes['waktu_mulai'] = \Carbon\Carbon::parse($value);
    }

    // Mutator untuk waktu_selesai
    public function setWaktuSelesaiAttribute($value)
    {
        $this->attributes['waktu_selesai'] = ($value) ? \Carbon\Carbon::parse($value) : null;
    }

    // Accessor untuk durasi
    public function getDurasiAttribute()
    {
        if ($this->waktu_selesai && $this->waktu_mulai) {
            $waktu_selesai = $this->waktu_selesai instanceof \Carbon\Carbon ? $this->waktu_selesai : \Carbon\Carbon::parse($this->waktu_selesai);
            $waktu_mulai = $this->waktu_mulai instanceof \Carbon\Carbon ? $this->waktu_mulai : \Carbon\Carbon::parse($this->waktu_mulai);
            $interval = $waktu_selesai->diffInMinutes($waktu_mulai);
            return abs($interval);
        }
        return null;
    }

    // Accessor untuk status sesi
    public function getStatusAttribute()
    {
        $now = \Carbon\Carbon::now();
        if ($this->waktu_selesai && $now->greaterThan($this->waktu_selesai)) {
            return 'Selesai';
        }
        return 'Aktif';
    }
}
