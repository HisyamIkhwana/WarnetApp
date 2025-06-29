<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus user lama jika ada untuk menghindari duplikat
        User::whereIn('email', [
            'admin@warnet.com',
            'warnet@warnet.com',
            'kasir@warnet.com'
        ])->delete();

        // Buat pengguna baru
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@warnet.com',
            'role' => 'admin', // Role tertinggi
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Penjaga Warnet',
            'email' => 'warnet@warnet.com',
            'role' => 'warnet', // Role penjaga warnet
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Kasir Warung',
            'email' => 'kasir@warnet.com',
            'role' => 'kasir', // Role kasir
            'password' => Hash::make('password'),
        ]);
    }
}