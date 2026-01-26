<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Produk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        @if ($produk->foto_produk)
                            <img src="{{ Storage::url($produk->foto_produk) }}" alt="{{ $produk->nama_produk }}"
                                class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-xl">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="md:w-1/2 p-6">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $produk->nama_produk }}</h1>
                        <p class="text-3xl font-bold text-blue-600 mt-4">Rp
                            {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-500 mt-2">Stok tersedia: {{ $produk->stok }}</p>

                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-700">Deskripsi</h3>
                            <p class="text-gray-600 mt-2">{{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>

                        <a href="{{ route('pembeli.transaksi.create', ['product' => $produk->id]) }}"
                            class="mt-6 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
                            Beli Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('pembeli.produk.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-900">←
                Kembali ke Daftar Produk</a>
        </div>
    </div>
</x-app-layout>
