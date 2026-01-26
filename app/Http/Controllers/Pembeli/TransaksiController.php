<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\OngkosKirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $pembeli = auth()->user()->pembeli;
        $transaksi = Transaksi::where('pelanggan_id', $pembeli->id)
            ->with(['detailTransaksi.produk', 'pembayaran'])
            ->latest()
            ->paginate(10);

        return view('pembeli.transaksi.index', compact('transaksi'));
    }

    public function create(Request $request)
    {
        $ongkosKirim = OngkosKirim::all();
        $allProducts = Produk::where('stok', '>', 0)->get();

        // jika ada product parameter, load produk tertentu
        $selectedProduct = null;
        if ($request->has('product')) {
            $selectedProduct = Produk::find($request->product);
        }

        return view('pembeli.transaksi.create', compact('ongkosKirim', 'allProducts', 'selectedProduct'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'daerah' => 'required|string',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $pembeli = auth()->user()->pembeli;
            $ongkosKirim = OngkosKirim::where('daerah', $request->daerah)->first();

            // Hitung total
            $subtotalProduk = 0;
            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);

                // Validasi stok
                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi.");
                }

                $subtotalProduk += $produk->harga * $item['jumlah'];
            }

            $totalBayar = $subtotalProduk + ($ongkosKirim->biaya ?? 0);

            // Buat transaksi
            $transaksi = Transaksi::create([
                'pelanggan_id' => $pembeli->id,
                'tanggal_transaksi' => now(),
                'daerah' => $request->daerah,
                'total_bayar' => $totalBayar,
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);

            // Buat detail transaksi (trigger akan mengurangi stok)
            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'harga_produk' => $produk->harga,
                    'jumlah_produk' => $item['jumlah'],
                    'subtotal' => $produk->harga * $item['jumlah'],
                ]);
            }

            DB::commit();
            return redirect()->route('pembeli.transaksi.show', $transaksi)->with('success', 'Transaksi berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Transaksi $transaksi)
    {
        // Pastikan hanya pemilik yang bisa lihat
        if ($transaksi->pelanggan_id !== auth()->user()->pembeli->id) {
            abort(403);
        }

        $transaksi->load(['detailTransaksi.produk', 'pembayaran']);
        $ongkosKirim = OngkosKirim::where('daerah', $transaksi->daerah)->first();

        return view('pembeli.transaksi.show', compact('transaksi', 'ongkosKirim'));
    }
}
