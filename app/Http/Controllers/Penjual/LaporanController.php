<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('penjual.laporan.index');
    }

    public function produkPdf()
    {
        $produk = Produk::all();
        $pdf = Pdf::loadView('penjual.laporan.produk-pdf', compact('produk'));
        return $pdf->download('laporan-produk-' . date('Y-m-d') . '.pdf');
    }

    public function transaksiPdf(Request $request)
    {
        $query = Transaksi::with(['pembeli', 'detailTransaksi.produk', 'pembayaran']);

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_sampai);
        }

        $transaksi = $query->get();
        $pdf = Pdf::loadView('penjual.laporan.transaksi-pdf', compact('transaksi'));
        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }

    public function pembayaranPdf(Request $request)
    {
        $query = Pembayaran::with(['transaksi.pembeli']);

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_pembayaran', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_pembayaran', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $pembayaran = $query->get();
        $totalPembayaran = $pembayaran->sum('total');
        $pdf = Pdf::loadView('penjual.laporan.pembayaran-pdf', compact('pembayaran', 'totalPembayaran'));
        return $pdf->download('laporan-pembayaran-' . date('Y-m-d') . '.pdf');
    }
}
