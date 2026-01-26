<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['pembeli.user', 'detailTransaksi.produk', 'pembayaran']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('metode')) {
            $query->whereHas('pembayaran', function ($q) use ($request) {
                $q->where('metode', $request->metode);
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksi = $query->latest()->paginate(10)->withQueryString();

        return view('penjual.transaksi.index', compact('transaksi'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pembeli.user', 'detailTransaksi.produk', 'pembayaran']);
        return view('penjual.transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:pending,dibayar,dikirim,selesai,batal',
        ]);

        $transaksi->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
