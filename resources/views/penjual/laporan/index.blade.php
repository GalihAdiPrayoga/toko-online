<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cetak Laporan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Laporan Produk -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Laporan Produk</h3>
                    <p class="text-gray-600 mb-4">Cetak daftar semua produk</p>
                    <a href="{{ route('penjual.laporan.produk-pdf') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
                        Download PDF
                    </a>
                </div>

                <!-- Laporan Transaksi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Laporan Transaksi</h3>
                    <form action="{{ route('penjual.laporan.transaksi-pdf') }}" method="GET">
                        <div class="mb-2">
                            <input type="date" name="tanggal_dari" class="w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Dari">
                        </div>
                        <div class="mb-4">
                            <input type="date" name="tanggal_sampai" class="w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Sampai">
                        </div>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Download PDF
                        </button>
                    </form>
                </div>

                <!-- Laporan Pembayaran -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Laporan Pembayaran</h3>
                    <form action="{{ route('penjual.laporan.pembayaran-pdf') }}" method="GET">
                        <div class="mb-2">
                            <input type="date" name="tanggal_dari" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                        </div>
                        <div class="mb-2">
                            <input type="date" name="tanggal_sampai" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                        </div>
                        <div class="mb-4">
                            <select name="metode" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">Semua Metode</option>
                                <option value="transfer">Transfer</option>
                                <option value="cod">COD</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
