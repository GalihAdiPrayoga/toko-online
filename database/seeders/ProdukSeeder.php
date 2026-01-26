<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produkList = [
            ['nama_produk' => 'Laptop ASUS VivoBook', 'deskripsi' => 'Laptop untuk kebutuhan sehari-hari', 'harga' => 7500000, 'stok' => 10],
            ['nama_produk' => 'Mouse Wireless Logitech', 'deskripsi' => 'Mouse wireless ergonomis', 'harga' => 250000, 'stok' => 50],
            ['nama_produk' => 'Keyboard Mechanical', 'deskripsi' => 'Keyboard gaming RGB', 'harga' => 850000, 'stok' => 25],
            ['nama_produk' => 'Monitor LED 24 inch', 'deskripsi' => 'Monitor Full HD IPS', 'harga' => 2100000, 'stok' => 15],
            ['nama_produk' => 'Headset Gaming', 'deskripsi' => 'Headset dengan surround sound', 'harga' => 450000, 'stok' => 30],
            ['nama_produk' => 'Webcam HD 1080p', 'deskripsi' => 'Webcam untuk meeting online', 'harga' => 350000, 'stok' => 20],
            ['nama_produk' => 'SSD 512GB', 'deskripsi' => 'SSD SATA untuk upgrade laptop', 'harga' => 650000, 'stok' => 40],
            ['nama_produk' => 'RAM DDR4 8GB', 'deskripsi' => 'RAM untuk upgrade PC/Laptop', 'harga' => 380000, 'stok' => 35],
        ];

        foreach ($produkList as $produk) {
            Produk::create($produk);
        }
    }
}
