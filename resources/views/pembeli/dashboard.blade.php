<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pembeli
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('pembeli.produk.index') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-blue-600">🛒 Lihat Produk</h3>
                    <p class="text-gray-600">Jelajahi produk yang tersedia</p>
                </a>
                <a href="{{ route('pembeli.transaksi.create') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-green-600">➕ Buat Transaksi</h3>
                    <p class="text-gray-600">Beli produk sekarang</p>
                </a>
                <a href="{{ route('pembeli.transaksi.index') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-purple-600">📋 Riwayat Transaksi</h3>
                    <p class="text-gray-600">Lihat semua pesanan Anda</p>
                </a>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Transaksi Terbaru Anda</h3>

                @if ($transaksiTerbaru->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transaksiTerbaru as $trx)
                                    <tr>
                                        <td class="px-6 py-4 font-medium">#{{ $trx->id }}</td>
                                        <td class="px-6 py-4">{{ $trx->tanggal_transaksi->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 font-semibold">Rp
                                            {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
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
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$trx->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($trx->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('pembeli.transaksi.show', $trx) }}"
                                                    class="text-blue-600 hover:text-blue-800">Detail</a>

                                                @if (!$trx->pembayaran && $trx->status === 'pending')
                                                    <a href="{{ route('pembeli.pembayaran.create', $trx) }}"
                                                        class="text-orange-600 hover:text-orange-800 font-semibold">
                                                        Bayar
                                                    </a>
                                                @endif

                                                @if ($trx->pembayaran)
                                                    <a href="{{ route('pembeli.invoice', $trx) }}"
                                                        class="text-green-600 hover:text-green-800">Invoice</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('pembeli.transaksi.index') }}" class="text-blue-600 hover:text-blue-800">
                            Lihat Semua Transaksi →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Belum ada transaksi.</p>
                        <a href="{{ route('pembeli.transaksi.create') }}"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition">
                            Buat Transaksi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
