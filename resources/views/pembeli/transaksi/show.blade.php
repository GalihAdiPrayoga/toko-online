<!-- filepath: c:\laragon\www\toko-online\resources\views\pembeli\transaksi\show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi #{{ $transaksi->id }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
                        <p><strong>Daerah:</strong> {{ $transaksi->daerah }}</p>
                        <p><strong>Keterangan:</strong> {{ $transaksi->keterangan ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <span
                            class="{{ 'px-3 py-1 text-sm rounded-full ' . ($transaksi->status === 'selesai' ? 'bg-green-100 text-green-800' : ($transaksi->status === 'batal' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-2">Detail Produk</h3>
                <table class="min-w-full divide-y divide-gray-200 mb-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $subtotal = 0; @endphp
                        @foreach ($transaksi->detailTransaksi as $detail)
                            @php $subtotal += $detail->subtotal; @endphp
                            <tr>
                                <td class="px-4 py-2">{{ $detail->produk->nama_produk }}</td>
                                <td class="px-4 py-2 text-right">Rp
                                    {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">{{ $detail->jumlah_produk }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="border-t pt-4">
                    <div class="flex justify-between">
                        <span>Subtotal Produk:</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkos Kirim ({{ $transaksi->daerah }}):</span>
                        <span>Rp {{ number_format($ongkosKirim->biaya ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold mt-2">
                        <span>Total Bayar:</span>
                        <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($transaksi->pembayaran)
                    <div class="mt-6 p-4 bg-green-50 rounded">
                        <h3 class="text-lg font-semibold text-green-700">✓ Sudah Dibayar</h3>
                        <p><strong>Metode:</strong> {{ ucfirst($transaksi->pembayaran->metode) }}</p>
                        <p><strong>Waktu:</strong> {{ $transaksi->pembayaran->waktu_pembayaran->format('d/m/Y H:i') }}
                        </p>
                    </div>
                @elseif($transaksi->status === 'pending')
                    <div class="mt-6">
                        <a href="{{ route('pembeli.pembayaran.create', $transaksi) }}"
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded inline-block">
                            Lakukan Pembayaran
                        </a>
                    </div>
                @endif

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('pembeli.transaksi.index') }}" class="text-blue-600 hover:text-blue-900">
                        ← Kembali ke Daftar
                    </a>

                    @if ($transaksi->pembayaran)
                        <a href="{{ route('pembeli.transaksi.invoice', $transaksi) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Cetak Invoice
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
