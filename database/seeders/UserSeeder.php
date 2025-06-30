<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::whereIn('email', [
            'admin@warnet.com',
            'warnet@warnet.com',
            'kasir@warnet.com'
        ])->delete();

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@warnet.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Penjaga Warnet',
            'email' => 'warnet@warnet.com',
            'role' => 'warnet',
            'password' => Hash::make('password'), 
        ]);

        User::create([
            'name' => 'Kasir Warung',
            'email' => 'kasir@warnet.com',
            'role' => 'kasir',
            'password' => Hash::make('password'),
        ]);
    }
}
