<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\OngkosKirim;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Transaksi $transaksi)
    {
        if ($transaksi->pelanggan_id !== auth()->user()->pembeli->id) {
            abort(403);
        }

        $transaksi->load(['pembeli.user', 'detailTransaksi.produk', 'pembayaran']);
        $ongkosKirim = OngkosKirim::where('daerah', $transaksi->daerah)->first();

        return view('pembeli.invoice.show', compact('transaksi', 'ongkosKirim'));
    }

    public function download(Transaksi $transaksi)
    {
        if ($transaksi->pelanggan_id !== auth()->user()->pembeli->id) {
            abort(403);
        }

        $transaksi->load(['pembeli.user', 'detailTransaksi.produk', 'pembayaran']);
        $ongkosKirim = OngkosKirim::where('daerah', $transaksi->daerah)->first();

        $pdf = Pdf::loadView('pembeli.invoice.pdf', compact('transaksi', 'ongkosKirim'));
        return $pdf->download('invoice-' . $transaksi->id . '.pdf');
    }
}
