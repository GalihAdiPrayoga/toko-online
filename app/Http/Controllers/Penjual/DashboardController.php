<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Pembayaran::sum('total');
        $transaksiTerbaru = Transaksi::with(['pembeli', 'pembayaran'])
            ->latest()
            ->take(5)
            ->get();

        return view('penjual.dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'totalPendapatan',
            'transaksiTerbaru'
        ));
    }
}
