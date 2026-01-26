<!-- filepath: c:\laragon\www\toko-online\resources\views\pembeli\produk\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Produk</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search -->
            <div class="mb-6">
                <form action="{{ route('pembeli.produk.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="flex-1 rounded-md border-gray-300 shadow-sm">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cari</button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($produk as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if($item->foto_produk)
                        <img src="{{ Storage::url($item->foto_produk) }}" alt="{{ $item->nama_produk }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $item->nama_produk }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($item->deskripsi, 50) }}</p>
                        <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-500 text-sm">Stok: {{ $item->stok }}</p>
                        <a href="{{ route('pembeli.produk.show', $item) }}" class="mt-3 inline-block bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $produk->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
