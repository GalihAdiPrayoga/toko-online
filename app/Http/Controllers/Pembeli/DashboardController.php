<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $pembeli = auth()->user()->pembeli;
        $transaksiTerbaru = Transaksi::where('pelanggan_id', $pembeli->id)
            ->with(['detailTransaksi.produk', 'pembayaran'])
            ->latest()
            ->take(5)
            ->get();

        return view('pembeli.dashboard', compact('transaksiTerbaru'));
    }
}
