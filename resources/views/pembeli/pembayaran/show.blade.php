<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi #{{ $transaksi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Header Info -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-gray-600"><strong>Tanggal:</strong>
                            {{ $transaksi->tanggal_transaksi->format('d F Y') }}</p>
                        <p class="text-gray-600"><strong>Daerah Pengiriman:</strong> {{ $transaksi->daerah }}</p>
                        <p class="text-gray-600"><strong>Keterangan:</strong> {{ $transaksi->keterangan ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'dibayar' => 'bg-blue-100 text-blue-800',
                                'dikirim' => 'bg-purple-100 text-purple-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'batal' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$transaksi->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </div>
                </div>

                <!-- Detail Produk -->
                <h3 class="text-lg font-semibold mb-3">Detail Produk</h3>
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
                        @php $subtotalProduk = 0; @endphp
                        @foreach ($transaksi->detailTransaksi as $detail)
                            @php $subtotalProduk += $detail->subtotal; @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if ($detail->produk->foto_produk)
                                            <img src="{{ Storage::url($detail->produk->foto_produk) }}"
                                                alt="{{ $detail->produk->nama_produk }}"
                                                class="w-12 h-12 object-cover rounded mr-3">
                                        @endif
                                        <span>{{ $detail->produk->nama_produk }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">Rp
                                    {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">{{ $detail->jumlah_produk }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total -->
                <div class="border-t pt-4">
                    <div class="flex justify-between py-1">
                        <span class="text-gray-600">Subtotal Produk</span>
                        <span>Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-gray-600">Ongkos Kirim ({{ $transaksi->daerah }})</span>
                        <span>Rp {{ number_format($ongkosKirim->biaya ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-xl font-bold border-t mt-2">
                        <span>Total Bayar</span>
                        <span class="text-blue-600">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Status Pembayaran -->
                @if ($transaksi->pembayaran)
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <h3 class="font-semibold text-green-800 mb-2">✅ Pembayaran Berhasil</h3>
                        <div class="text-sm text-green-700 space-y-1">
                            <p><strong>Metode:</strong> {{ ucfirst($transaksi->pembayaran->metode) }}</p>
                            <p><strong>Waktu Pembayaran:</strong>
                                {{ $transaksi->pembayaran->waktu_pembayaran->format('d F Y, H:i') }}</p>
                            <p><strong>Total Dibayar:</strong> Rp
                                {{ number_format($transaksi->pembayaran->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @elseif($transaksi->status === 'pending')
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h3 class="font-semibold text-yellow-800 mb-2">⏳ Menunggu Pembayaran</h3>
                        <p class="text-sm text-yellow-700 mb-4">Silakan lakukan pembayaran untuk melanjutkan pesanan
                            Anda.</p>
                        <a href="{{ route('pembeli.pembayaran.create', $transaksi) }}"
                            class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition">
                            Bayar Sekarang
                        </a>
                    </div>
                @elseif($transaksi->status === 'batal')
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h3 class="font-semibold text-red-800 mb-2">❌ Transaksi Dibatalkan</h3>
                        <p class="text-sm text-red-700">Transaksi ini telah dibatalkan.</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('pembeli.transaksi.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Kembali ke Riwayat Transaksi
                    </a>

                    @if ($transaksi->pembayaran)
                        <a href="{{ route('pembeli.invoice', $transaksi) }}"
                            class="ml-auto bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                            Lihat Invoice
                        </a>
                        <a href="{{ route('pembeli.invoice.download', $transaksi) }}"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                            Download PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
