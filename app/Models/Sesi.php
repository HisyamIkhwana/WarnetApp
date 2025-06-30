<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'komputer_id',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function komputer()
    {
        return $this->belongsTo(Komputer::class, 'komputer_id');
    }

    public function setWaktuMulaiAttribute($value)
    {
        $this->attributes['waktu_mulai'] = \Carbon\Carbon::parse($value);
    }

    public function setWaktuSelesaiAttribute($value)
    {
        $this->attributes['waktu_selesai'] = ($value) ? \Carbon\Carbon::parse($value) : null;
    }

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

    public function getStatusAttribute()
    {
        $now = \Carbon\Carbon::now();
        if ($this->waktu_selesai && $now->greaterThan($this->waktu_selesai)) {
            return 'Selesai';
        }
        return 'Aktif';
    }
}
