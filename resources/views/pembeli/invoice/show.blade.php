<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice #{{ $transaksi->id }}</h2>
            <a href="{{ route('pembeli.invoice.download', $transaksi) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">INVOICE</h1>
                        <p class="text-gray-600">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Tanggal: {{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
                        <p class="text-gray-600">Status: <span class="font-semibold text-green-600">{{ ucfirst($transaksi->status) }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Dari:</h3>
                        <p class="text-gray-600">Toko Online</p>
                        <p class="text-gray-600">Jl. Merdeka No. 123</p>
                        <p class="text-gray-600">support@toko.com</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Kepada:</h3>
                        <p class="text-gray-600">{{ $transaksi->pembeli->nama_pembeli }}</p>
                        <p class="text-gray-600">{{ $transaksi->pembeli->alamat ?? '-' }}</p>
                        <p class="text-gray-600">{{ $transaksi->pembeli->no_hp ?? '-' }}</p>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-6">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $subtotal = 0; @endphp
                        @foreach($transaksi->detailTransaksi as $detail)
                        @php $subtotal += $detail->subtotal; @endphp
                        <tr>
                            <td class="px-4 py-3">{{ $detail->produk->nama_produk }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">{{ $detail->jumlah_produk }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span>Ongkos Kirim:</span>
                            <span>Rp {{ number_format($ongkosKirim->biaya ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t font-bold text-lg">
                            <span>Total:</span>
                            <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($transaksi->pembayaran)
                <div class="mt-8 p-4 bg-green-50 rounded-lg">
                    <h3 class="font-semibold text-green-700 mb-2">Informasi Pembayaran</h3>
                    <p><strong>Metode:</strong> {{ ucfirst($transaksi->pembayaran->metode) }}</p>
                    <p><strong>Waktu Bayar:</strong> {{ $transaksi->pembayaran->waktu_pembayaran->format('d/m/Y H:i') }}</p>
                    <p><strong>Total Dibayar:</strong> Rp {{ number_format($transaksi->pembayaran->total, 0, ',', '.') }}</p>
                </div>
                @endif

                <div class="mt-8 text-center text-gray-500 text-sm">
                    <p>Terima kasih telah berbelanja di Toko Online!</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('pembeli.transaksi.index') }}" class="text-blue-600 hover:text-blue-900">← Kembali ke Riwayat Transaksi</a>
            </div>
        </div>
    </div>
</x-app-layout>
