<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the UserSeeder class
        $this->call(UserSeeder::class);
        $this->call(WarnetSeeder::class);
        $this->call(KomputerSeeder::class);
        $this->call(ProdukSeeder::class);
    }
}
