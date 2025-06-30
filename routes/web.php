<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WarnetController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KomputerController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesanController;

Route::get('/', [PesanController::class, 'index'])->name('pesan.index');
Route::post('/pesan/store', [PesanController::class, 'store'])->name('pesan.store');

require __DIR__.'/auth.php';


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/warnet/dashboard', [WarnetController::class, 'index'])->name('warnet.index');
    Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.index');

    Route::resource('komputer', KomputerController::class); 
    Route::resource('sesi', SesiController::class); 

    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index'); 
    Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout'); 
    Route::get('/kasir/pesanan', [KasirController::class, 'pesanan'])->name('kasir.pesanan'); 
    Route::post('/kasir/pesanan/{pesanan}/konfirmasi', [KasirController::class, 'konfirmasiPesanan'])->name('kasir.pesanan.konfirmasi'); 
    Route::post('/kasir/pesanan/{pesanan}/bayar', [KasirController::class, 'selesaikanPembayaran'])->name('kasir.pesanan.bayar'); 
    Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi'); 

    Route::get('/kasir/menu', [ProdukController::class, 'index'])->name('kasir.menu'); 
    Route::post('/kasir/menu', [ProdukController::class, 'store'])->name('kasir.menu.store'); 
    Route::put('/kasir/menu/{produk}', [ProdukController::class, 'update'])->name('kasir.menu.update'); 
    Route::delete('/kasir/menu/{produk}', [ProdukController::class, 'destroy'])->name('kasir.menu.destroy'); 
});
