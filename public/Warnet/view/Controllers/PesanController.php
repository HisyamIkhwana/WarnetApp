<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PesanController extends Controller
{
    /**
     * Menampilkan halaman menu untuk pengguna.
     */
    public function index()
    {
        $produks = Produk::where('stok', '>', 0)->orderBy('kategori')->orderBy('nama')->get();
        return view('user.pesan', compact('produks'));
    }

    /**
     * Menyimpan pesanan yang dibuat oleh pengguna.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'no_meja' => 'required|string|max:50', // Nomor Komputer/Meja wajib diisi
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($validated['items'] as $itemData) {
                $produk = Produk::find($itemData['id']);
                if ($produk->stok < $itemData['jumlah']) {
                    throw new \Exception('Stok untuk ' . $produk->nama . ' tidak mencukupi.');
                }
                $subtotal += $produk->harga * $itemData['jumlah'];
            }
            
            $totalHarga = $subtotal * 1.10; // Langsung tambahkan pajak 10%

            // Buat pesanan dengan status 'online'
            $pesanan = Pesanan::create([
                'no_meja' => $validated['no_meja'],
                'status' => 'online', // Status khusus untuk pesanan dari user
                'total_harga' => $totalHarga,
            ]);

            // Simpan item pesanan dan kurangi stok
            foreach ($validated['items'] as $itemData) {
                $produk = Produk::find($itemData['id']);
                ItemPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $itemData['jumlah'],
                    'harga_saat_pesan' => $produk->harga,
                ]);

                $produk->stok -= $itemData['jumlah'];
                $produk->save();
            }

            DB::commit();

            return response()->json(['message' => 'Pesanan berhasil dikirim! Silakan tunggu konfirmasi dari kasir.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User order failed: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal membuat pesanan: ' . $e->getMessage()], 500);
        }
    }
}