<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboard;
use App\Http\Controllers\Penjual\ProdukController as PenjualProduk;
use App\Http\Controllers\Penjual\TransaksiController as PenjualTransaksi;
use App\Http\Controllers\Penjual\LaporanController as PenjualLaporan;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboard;
use App\Http\Controllers\Pembeli\ProdukController as PembeliProduk;
use App\Http\Controllers\Pembeli\TransaksiController as PembeliTransaksi;
use App\Http\Controllers\Pembeli\PembayaranController as PembeliPembayaran;
use App\Http\Controllers\Pembeli\InvoiceController as PembeliInvoice;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'penjual') {
            return redirect()->route('penjual.dashboard');
        }
        return redirect()->route('pembeli.dashboard');
    }
    return view('welcome');
});

// Routes untuk Penjual
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PenjualDashboard::class, 'index'])->name('dashboard');

    // Produk
    Route::resource('produk', PenjualProduk::class)->except(['show']);

    // Transaksi
    Route::get('/transaksi', [PenjualTransaksi::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [PenjualTransaksi::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{transaksi}/status', [PenjualTransaksi::class, 'updateStatus'])->name('transaksi.update-status');

    // Laporan
    Route::get('/laporan', [PenjualLaporan::class, 'index'])->name('laporan.index');
    Route::get('/laporan/produk/pdf', [PenjualLaporan::class, 'produkPdf'])->name('laporan.produk-pdf');
    Route::get('/laporan/transaksi/pdf', [PenjualLaporan::class, 'transaksiPdf'])->name('laporan.transaksi-pdf');
    Route::get('/laporan/pembayaran/pdf', [PenjualLaporan::class, 'pembayaranPdf'])->name('laporan.pembayaran-pdf');
});

// Routes untuk Pembeli
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [PembeliDashboard::class, 'index'])->name('dashboard');

    // Produk
    Route::get('/produk', [PembeliProduk::class, 'index'])->name('produk.index');
    Route::get('/produk/{produk}', [PembeliProduk::class, 'show'])->name('produk.show');

    // Transaksi
    Route::get('/transaksi', [PembeliTransaksi::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [PembeliTransaksi::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [PembeliTransaksi::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [PembeliTransaksi::class, 'show'])->name('transaksi.show');

    // Pembayaran
    Route::get('/pembayaran/{transaksi}', [PembeliPembayaran::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/{transaksi}', [PembeliPembayaran::class, 'store'])->name('pembayaran.store');

    // Invoice
    Route::get('/invoice/{transaksi}', [PembeliInvoice::class, 'show'])->name('invoice');
    Route::get('/invoice/{transaksi}/download', [PembeliInvoice::class, 'download'])->name('invoice.download');
});

require __DIR__ . '/auth.php';
