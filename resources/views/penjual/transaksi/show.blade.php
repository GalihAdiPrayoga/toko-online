<!-- filepath: c:\laragon\www\toko-online\resources\views\penjual\transaksi\show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi #{{ $transaksi->id }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold">Informasi Pembeli</h3>
                        <p><strong>Nama:</strong> {{ $transaksi->pembeli->nama_pembeli }}</p>
                        <p><strong>Alamat:</strong> {{ $transaksi->pembeli->alamat ?? '-' }}</p>
                        <p><strong>No HP:</strong> {{ $transaksi->pembeli->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Informasi Transaksi</h3>
                        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
                        <p><strong>Daerah:</strong> {{ $transaksi->daerah }}</p>
                        <p><strong>Keterangan:</strong> {{ $transaksi->keterangan ?? '-' }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-2">Detail Produk</h3>
                <table class="min-w-full divide-y divide-gray-200 mb-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transaksi->detailTransaksi as $detail)
                        <tr>
                            <td class="px-4 py-2">{{ $detail->produk->nama_produk }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $detail->jumlah_produk }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right">
                    <p class="text-xl font-bold">Total: Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                </div>

                @if($transaksi->pembayaran)
                <div class="mt-4 p-4 bg-green-50 rounded">
                    <h3 class="text-lg font-semibold text-green-700">Pembayaran</h3>
                    <p><strong>Metode:</strong> {{ ucfirst($transaksi->pembayaran->metode) }}</p>
                    <p><strong>Waktu:</strong> {{ $transaksi->pembayaran->waktu_pembayaran->format('d/m/Y H:i') }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($transaksi->pembayaran->total, 0, ',', '.') }}</p>
                </div>
                @endif

                <div class="mt-6">
                    <form action="{{ route('penjual.transaksi.update-status', $transaksi) }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded-md border-gray-300 shadow-sm">
                            <option value="pending" {{ $transaksi->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibayar" {{ $transaksi->status === 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="dikirim" {{ $transaksi->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $transaksi->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ $transaksi->status === 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <a href="{{ route('penjual.transaksi.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
