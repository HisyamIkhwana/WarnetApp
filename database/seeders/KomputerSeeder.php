<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komputer;

class KomputerSeeder extends Seeder
{
    public function run(): void
    {
        $komputerData = [
            ['merk' => 'Dell', 'spesifikasi' => 'Intel i5, 8GB RAM, 256GB SSD', 'status' => true],
            ['merk' => 'HP', 'spesifikasi' => 'Intel i7, 16GB RAM, 512GB SSD', 'status' => true],
            ['merk' => 'Asus', 'spesifikasi' => 'AMD Ryzen 5, 8GB RAM, 1TB HDD', 'status' => true],
            ['merk' => 'Acer', 'spesifikasi' => 'Intel i3, 4GB RAM, 500GB HDD', 'status' => true],
            ['merk' => 'Lenovo', 'spesifikasi' => 'Intel i5, 8GB RAM, 256GB SSD', 'status' => true],
            ['merk' => 'MSI', 'spesifikasi' => 'Intel i7, 16GB RAM, 1TB SSD', 'status' => true],
            ['merk' => 'Apple', 'spesifikasi' => 'M1, 8GB RAM, 256GB SSD', 'status' => true],
            ['merk' => 'Samsung', 'spesifikasi' => 'Intel i5, 8GB RAM, 512GB SSD', 'status' => true],
            ['merk' => 'Toshiba', 'spesifikasi' => 'Intel i3, 4GB RAM, 500GB HDD', 'status' => true],
            ['merk' => 'Sony', 'spesifikasi' => 'Intel i7, 16GB RAM, 1TB HDD', 'status' => true],
            ['merk' => 'Dell', 'spesifikasi' => 'Intel i5, 8GB RAM, 256GB SSD', 'status' => true],
            ['merk' => 'HP', 'spesifikasi' => 'Intel i7, 16GB RAM, 512GB SSD', 'status' => true],
            ['merk' => 'Asus', 'spesifikasi' => 'AMD Ryzen 5, 8GB RAM, 1TB HDD', 'status' => true],
            ['merk' => 'Acer', 'spesifikasi' => 'Intel i3, 4GB RAM, 500GB HDD', 'status' => true],
            ['merk' => 'Lenovo', 'spesifikasi' => 'Intel i5, 8GB RAM, 256GB SSD', 'status' => true],
        ];

        foreach ($komputerData as $data) {
            Komputer::create(array_merge($data, ['warnet_id' => 1]));
        }
    }
}
