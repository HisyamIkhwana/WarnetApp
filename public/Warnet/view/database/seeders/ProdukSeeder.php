<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Mengosongkan tabel. Sekarang perintah ini akan berhasil.
        DB::table('produks')->truncate();
        
        // Kita juga bisa mengosongkan tabel lain yang berhubungan jika diperlukan
        DB::table('item_pesanans')->truncate();
        DB::table('pesanans')->truncate();
        DB::table('transaksis')->truncate();

        DB::table('produks')->insert([
            // === MAKANAN ===
            [
                'nama' => 'Indomie Goreng Telor',
                'deskripsi' => 'Indomie goreng jumbo dengan telur mata sapi.',
                'harga' => 12000,
                'kategori' => 'makanan',
                'icon' => '🍜',
                'stok' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Indomie Rebus Telor',
                'deskripsi' => 'Indomie kuah rasa kari ayam dengan telur dan sawi.',
                'harga' => 12000,
                'kategori' => 'makanan',
                'icon' => '🍲',
                'stok' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Nasi Goreng Spesial',
                'deskripsi' => 'Nasi goreng dengan sosis, bakso, dan telur.',
                'harga' => 18000,
                'kategori' => 'makanan',
                'icon' => '🍚',
                'stok' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Roti Bakar Coklat Keju',
                'deskripsi' => 'Roti bakar garing dengan topping meses coklat dan keju parut.',
                'harga' => 10000,
                'kategori' => 'makanan',
                'icon' => '🍞',
                'stok' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // === MINUMAN ===
            [
                'nama' => 'Es Teh Manis',
                'deskripsi' => 'Teh manis dingin yang menyegarkan.',
                'harga' => 5000,
                'kategori' => 'minuman',
                'icon' => '🧊',
                'stok' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Kopi ABC Susu Panas',
                'deskripsi' => 'Kopi sachet ABC Susu diseduh panas.',
                'harga' => 5000,
                'kategori' => 'minuman',
                'icon' => '☕',
                'stok' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Good Day Freeze',
                'deskripsi' => 'Kopi Good Day Freeze dingin diblender dengan es.',
                'harga' => 8000,
                'kategori' => 'minuman',
                'icon' => '🥤',
                'stok' => 80,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Coca-cola Dingin',
                'deskripsi' => 'Minuman soda Coca-cola dalam botol.',
                'harga' => 7000,
                'kategori' => 'minuman',
                'icon' => '🍾',
                'stok' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // === SNACK ===
            [
                'nama' => 'Chitato Sapi Panggang',
                'deskripsi' => 'Keripik kentang rasa sapi panggang.',
                'harga' => 10000,
                'kategori' => 'snack',
                'icon' => '🥔',
                'stok' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Taro Net',
                'deskripsi' => 'Snack jaring aneka rasa.',
                'harga' => 3000,
                'kategori' => 'snack',
                'icon' => '🥠',
                'stok' => 70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Kacang Garuda',
                'deskripsi' => 'Kacang kulit asin gurih.',
                'harga' => 5000,
                'kategori' => 'snack',
                'icon' => '🥜',
                'stok' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Mengaktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}