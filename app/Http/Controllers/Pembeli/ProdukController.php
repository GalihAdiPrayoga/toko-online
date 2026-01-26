<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::where('stok', '>', 0);

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produk = $query->latest()->paginate(12);
        return view('pembeli.produk.index', compact('produk'));
    }

    public function show(Produk $produk)
    {
        return view('pembeli.produk.show', compact('produk'));
    }
}
