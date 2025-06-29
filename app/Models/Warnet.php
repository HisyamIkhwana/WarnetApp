<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warnet extends Model
{
    public function komputers()
    {
        return $this->hasMany(Komputer::class, 'warnet_id');
    }
}
