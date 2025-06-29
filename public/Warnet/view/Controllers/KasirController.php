<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    /**
     * Menampilkan halaman utama kasir dengan produk dan pesanan aktif.
     */
    public function index()
    {
        $produks = Produk::orderBy('nama')->get();

        $pesananAktif = Pesanan::with('items.produk')
                                ->where('status', 'selesai')
                                ->whereDoesntHave('transaksi')
                                ->latest()
                                ->get();

        return view('kasir.index', compact('produks', 'pesananAktif'));
    }

    /**
     * Memproses checkout untuk pesanan baru (walk-in).
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($validated['items'] as $itemData) {
                $produk = Produk::find($itemData['id']);
                if ($produk->stok < $itemData['jumlah']) {
                    throw new \Exception('Stok untuk produk ' . $produk->nama . ' tidak mencukupi.');
                }
                $subtotal += $produk->harga * $itemData['jumlah'];
            }

            $totalHarga = $subtotal * 1.10; // Pajak 10%

            $pesanan = Pesanan::create([
                'nama_pelanggan' => 'Walk-in',
                'status' => 'selesai',
                'total_harga' => $totalHarga,
            ]);

            foreach ($validated['items'] as $itemData) {
                $produk = Produk::find($itemData['id']);
                $produk->stok -= $itemData['jumlah'];
                $produk->save();

                $pesanan->items()->create([
                    'produk_id' => $produk->id,
                    'jumlah' => $itemData['jumlah'],
                    'harga_saat_pesan' => $produk->harga,
                ]);
            }

            Transaksi::create([
                'pesanan_id' => $pesanan->id,
                'jumlah_bayar' => $totalHarga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Pesanan walk-in berhasil diselesaikan.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memproses pesanan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan halaman pesanan online yang masuk.
     */
    public function pesanan()
    {
        $pesananOnline = Pesanan::with('items.produk')
                                  ->where('status', 'online')
                                  ->latest()
                                  ->get();
        return view('kasir.pesanan', compact('pesananOnline'));
    }

    /**
     * Menampilkan halaman riwayat transaksi.
     */
    public function transaksi()
    {
        $transaksis = Transaksi::with('pesanan.items.produk')
                                ->latest()
                                ->paginate(15);
        return view('kasir.transaksi', compact('transaksis'));
    }

    /**
     * Mengonfirmasi pesanan online dari user, mengubah statusnya.
     */
    public function konfirmasiPesanan(Pesanan $pesanan)
    {
        $pesanan->status = 'selesai';
        $pesanan->save();

        return redirect()->route('kasir.pesanan')->with('success', 'Pesanan #' . $pesanan->id . ' telah dikonfirmasi.');
    }

    /**
     * Membuat catatan transaksi untuk pesanan yang sudah ada (dari pesanan online).
     */
    public function selesaikanPembayaran(Request $request, Pesanan $pesanan)
    {
        $request->validate(['metode_pembayaran' => 'required|string']);

        if ($pesanan->transaksi) {
            return response()->json(['message' => 'Pesanan ini sudah memiliki transaksi.'], 409);
        }

        Transaksi::create([
            'pesanan_id' => $pesanan->id,
            'jumlah_bayar' => $pesanan->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return response()->json(['message' => 'Pembayaran untuk Pesanan #' . $pesanan->id . ' berhasil diselesaikan.']);
    }
}