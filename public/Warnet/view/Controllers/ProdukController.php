<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan halaman manajemen menu dengan data produk.
     * Kita ganti nama metodenya dari 'menu' menjadi 'index' agar sesuai standar.
     */
    public function index()
    {
        $produks = Produk::latest()->paginate(10); // Ambil 10 produk per halaman
        return view('kasir.menu', compact('produks'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:produks',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create($request->all());

        return redirect()->route('kasir.menu')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Memperbarui data produk yang ada.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:produks,nama,' . $produk->id,
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $produk->update($request->all());

        return redirect()->route('kasir.menu')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('kasir.menu')->with('success', 'Produk berhasil dihapus.');
    }
}