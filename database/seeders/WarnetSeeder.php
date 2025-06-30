<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warnet;

class WarnetSeeder extends Seeder
{
    public function run(): void
    {
        Warnet::create([
            'nama' => 'Warnet Default',
            'alamat' => 'Alamat Default',
        ]);
    }
}
