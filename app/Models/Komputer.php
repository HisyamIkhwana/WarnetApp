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
        'status', 
    ];

    protected $table = 'komputers';
    
    public function warnet()
    {
        return $this->belongsTo(Warnet::class, 'warnet_id');
    }
    
    public function sesis()
    {
        return $this->hasMany(Sesi::class, 'komputer_id');
    }
    
    public function sesiAktif()
    {
        return $this->hasOne(Sesi::class, 'komputer_id')->where('waktu_selesai', '>', now());
    }
    
    public function getStatusAttribute()
    {
        if (isset($this->attributes['status']) && $this->attributes['status'] == 'nonaktif') {
            return 'nonaktif';
        }
        if ($this->sesiAktif()->exists()) {
            return 'terpakai';
        }
        return 'tersedia';
    }
}
