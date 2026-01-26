<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Transaksi #{{ $transaksi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ringkasan Transaksi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Pesanan</h3>

                <div class="space-y-2 text-sm">
                    @foreach ($transaksi->detailTransaksi as $detail)
                        <div class="flex justify-between">
                            <span>{{ $detail->produk->nama_produk }} x {{ $detail->jumlah_produk }}</span>
                            <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <hr class="my-4">

                <div class="flex justify-between text-sm">
                    <span>Subtotal Produk</span>
                    <span>Rp {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Ongkos Kirim ({{ $transaksi->daerah }})</span>
                    <span>Rp
                        {{ number_format($transaksi->total_bayar - $transaksi->detailTransaksi->sum('subtotal'), 0, ',', '.') }}</span>
                </div>

                <hr class="my-4">

                <div class="flex justify-between text-xl font-bold text-blue-600">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Form Pembayaran -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Pilih Metode Pembayaran</h3>

                <form action="{{ route('pembeli.pembayaran.store', $transaksi) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-3 mb-6">
                        <!-- Transfer Bank -->
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="metode" value="transfer" class="w-5 h-5 text-blue-600"
                                required>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">🏦</span>
                                    <div>
                                        <span class="font-semibold text-gray-800">Transfer Bank</span>
                                        <p class="text-sm text-gray-500">BCA, BNI, BRI, Mandiri</p>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="metode" value="ewallet" class="w-5 h-5 text-blue-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">📱</span>
                                    <div>
                                        <span class="font-semibold text-gray-800">E-Wallet</span>
                                        <p class="text-sm text-gray-500">OVO, GoPay, DANA, ShopeePay</p>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="metode" value="cod" class="w-5 h-5 text-blue-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">🚚</span>
                                    <div>
                                        <span class="font-semibold text-gray-800">COD (Cash on Delivery)</span>
                                        <p class="text-sm text-gray-500">Bayar saat barang sampai</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Bukti pembayaran (hanya untuk transfer / ewallet) -->
                    <div id="buktiWrapper" class="mb-4" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran (JPG/PNG, max
                            2MB)</label>
                        <input type="file" name="bukti" accept="image/*"
                            class="block w-full text-sm text-gray-700">
                        @error('bukti')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    @error('metode')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        Konfirmasi Pembayaran
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('pembeli.transaksi.show', $transaksi) }}"
                        class="text-gray-600 hover:text-gray-800">
                        ← Kembali ke Detail Transaksi
                    </a>
                </div>
            </div>

            <!-- Info Pembayaran -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-semibold text-yellow-800 mb-2">📌 Informasi Pembayaran</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Untuk Transfer Bank, silakan transfer ke rekening yang akan ditampilkan setelah konfirmasi.
                    </li>
                    <li>• Untuk E-Wallet, Anda akan diarahkan ke aplikasi pembayaran.</li>
                    <li>• Untuk COD, siapkan uang pas saat barang sampai.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function updateBuktiVisibility() {
            const metode = document.querySelector('input[name="metode"]:checked')?.value;
            const wrapper = document.getElementById('buktiWrapper');
            if (metode && (metode === 'transfer' || metode === 'ewallet')) {
                wrapper.style.display = 'block';
            } else {
                wrapper.style.display = 'none';
            }
        }

        document.querySelectorAll('input[name="metode"]').forEach(r => {
            r.addEventListener('change', updateBuktiVisibility);
        });

        // initial state
        updateBuktiVisibility();
    </script>
</x-app-layout>
