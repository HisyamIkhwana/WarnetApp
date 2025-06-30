<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(WarnetSeeder::class);
        $this->call(KomputerSeeder::class);
        $this->call(ProdukSeeder::class);
    }
}
