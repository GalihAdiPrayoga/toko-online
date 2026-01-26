<!-- filepath: c:\laragon\www\toko-online\resources\views\pembeli\transaksi\index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Transaksi</h2>
            <a href="{{ route('pembeli.transaksi.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                + Buat Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Daerah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transaksi as $trx)
                            <tr>
                                <td class="px-6 py-4 font-medium">#{{ $trx->id }}</td>
                                <td class="px-6 py-4">{{ $trx->tanggal_transaksi->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $trx->daerah }}</td>
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
                                            class="text-blue-600 hover:text-blue-800 font-medium">
                                            Detail
                                        </a>

                                        @if (!$trx->pembayaran && $trx->status === 'pending')
                                            <a href="{{ route('pembeli.pembayaran.create', $trx) }}"
                                                class="text-orange-600 hover:text-orange-800 font-medium">
                                                Bayar
                                            </a>
                                        @endif

                                        @if ($trx->pembayaran)
                                            <a href="{{ route('pembeli.invoice', $trx) }}"
                                                class="text-green-600 hover:text-green-800 font-medium">
                                                Invoice
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <p class="text-lg mb-2">Belum ada transaksi</p>
                                        <a href="{{ route('pembeli.transaksi.create') }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            Buat transaksi pertama Anda →
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($transaksi->hasPages())
                    <div class="p-4 border-t">
                        {{ $transaksi->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
