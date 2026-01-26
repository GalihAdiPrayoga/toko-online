<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function create(Transaksi $transaksi)
    {
        // Pastikan hanya pemilik yang bisa bayar
        if ($transaksi->pelanggan_id !== auth()->user()->pembeli->id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah sudah dibayar
        if ($transaksi->pembayaran) {
            return redirect()->route('pembeli.transaksi.show', $transaksi)
                ->with('error', 'Transaksi sudah dibayar.');
        }

        // Cek status transaksi
        if ($transaksi->status === 'batal') {
            return redirect()->route('pembeli.transaksi.show', $transaksi)
                ->with('error', 'Transaksi sudah dibatalkan.');
        }

        return view('pembeli.pembayaran.create', compact('transaksi'));
    }

    public function store(Request $request, Transaksi $transaksi)
    {
        // Pastikan hanya pemilik yang bisa bayar
        if ($transaksi->pelanggan_id !== auth()->user()->pembeli->id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah sudah dibayar
        if ($transaksi->pembayaran) {
            return redirect()->route('pembeli.transaksi.show', $transaksi)
                ->with('error', 'Transaksi sudah dibayar.');
        }

        $request->validate([
            'metode' => 'required|in:transfer,cod,ewallet',
            // jika metode bukan cod, bukti wajib (image)
            'bukti' => 'required_if:metode,transfer,ewallet|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('pembayaran', 'public');
        }

        // Buat pembayaran
        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'waktu_pembayaran' => now(),
            'total' => $transaksi->total_bayar,
            'metode' => $request->metode,
            'bukti' => $buktiPath,
        ]);

        // Update status transaksi
        $transaksi->update(['status' => 'dibayar']);

        return redirect()->route('pembeli.invoice', $transaksi)
            ->with('success', 'Pembayaran berhasil dilakukan.');
    }
}
