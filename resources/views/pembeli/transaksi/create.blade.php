<!-- filepath: c:\laragon\www\toko-online\resources\views\pembeli\transaksi\create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Transaksi Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('pembeli.transaksi.store') }}" method="POST" id="transaksiForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Daerah Pengiriman</label>
                        <select name="daerah" id="daerah"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('daerah') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Daerah</option>
                            @foreach ($ongkosKirim as $ongkir)
                                <option value="{{ $ongkir->daerah }}" data-biaya="{{ $ongkir->biaya }}">
                                    {{ $ongkir->daerah }} - Rp {{ number_format($ongkir->biaya, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('daerah')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Produk</label>
                        <div id="produkContainer">
                            @if ($selectedProduct)
                                <!-- Jika ada produk terpilih, tampilkan hanya produk itu -->
                                <div class="flex gap-2 mb-2 produk-item">
                                    <div class="flex-1 p-3 border rounded bg-gray-50 flex items-center">
                                        @if ($selectedProduct->foto_produk)
                                            <img src="{{ Storage::url($selectedProduct->foto_produk) }}"
                                                alt="{{ $selectedProduct->nama_produk }}"
                                                class="w-12 h-12 object-cover rounded mr-3">
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $selectedProduct->nama_produk }}
                                            </p>
                                            <p class="text-sm text-gray-600">Rp
                                                {{ number_format($selectedProduct->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="items[0][produk_id]" value="{{ $selectedProduct->id }}"
                                        data-harga="{{ $selectedProduct->harga }}"
                                        data-stok="{{ $selectedProduct->stok }}" class="produk-select-hidden">
                                    <input type="number" name="items[0][jumlah]" min="1"
                                        max="{{ $selectedProduct->stok }}" value="{{ request('qty', 1) }}"
                                        class="w-24 shadow border rounded py-2 px-3 jumlah-input" required>
                                    <button type="button" class="bg-red-500 text-white px-3 py-2 rounded remove-item"
                                        style="display:none;">×</button>
                                </div>
                            @else
                                <!-- Jika tidak ada produk terpilih, tampilkan form dropdown -->
                                <div class="flex gap-2 mb-2 produk-item">
                                    <select name="items[0][produk_id]"
                                        class="flex-1 shadow border rounded py-2 px-3 produk-select" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach ($allProducts as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga }}"
                                                data-stok="{{ $p->stok }}" data-nama="{{ $p->nama_produk }}"
                                                data-foto="{{ $p->foto_produk }}">
                                                {{ $p->nama_produk }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                                (Stok: {{ $p->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="items[0][jumlah]" min="1" value="1"
                                        class="w-24 shadow border rounded py-2 px-3 jumlah-input" required>
                                    <button type="button" class="bg-red-500 text-white px-3 py-2 rounded remove-item"
                                        style="display:none;">×</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="addProduk"
                            class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                            + Tambah Produk Lain
                        </button>
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between text-lg">
                            <span>Subtotal Produk:</span>
                            <span id="subtotalProduk">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-lg">
                            <span>Ongkos Kirim:</span>
                            <span id="ongkosKirim">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold mt-2">
                            <span>Total:</span>
                            <span id="totalBayar">Rp 0</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded w-full">
                            Buat Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;
        const isSelectedProduct = {{ $selectedProduct ? 'true' : 'false' }};

        let produkOptions = '';
        @if (!$selectedProduct)
            produkOptions = document.querySelector('.produk-select').innerHTML
                .replace(/selected="selected"/g, '')
                .replace(/\sselected\b/g, '');
        @endif

        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.produk-item').forEach(item => {
                let harga = 0;
                const jumlah = parseInt(item.querySelector('.jumlah-input').value) || 0;

                if (isSelectedProduct && item === document.querySelector('.produk-item')) {
                    // item pertama dengan produk terpilih
                    harga = parseFloat(item.querySelector('.produk-select-hidden').dataset.harga);
                } else {
                    const select = item.querySelector('.produk-select');
                    if (select) {
                        const option = select.options[select.selectedIndex];
                        if (option && option.dataset.harga) {
                            harga = parseFloat(option.dataset.harga);
                        }
                    }
                }

                subtotal += harga * jumlah;
            });

            const daerahSelect = document.getElementById('daerah');
            const ongkir = daerahSelect.options[daerahSelect.selectedIndex]?.dataset?.biaya || 0;

            document.getElementById('subtotalProduk').textContent = formatRupiah(subtotal);
            document.getElementById('ongkosKirim').textContent = formatRupiah(parseFloat(ongkir));
            document.getElementById('totalBayar').textContent = formatRupiah(subtotal + parseFloat(ongkir));
        }

        document.getElementById('addProduk').addEventListener('click', function() {
            const container = document.getElementById('produkContainer');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 produk-item';
            div.innerHTML = `
                <select name="items[${itemIndex}][produk_id]" class="flex-1 shadow border rounded py-2 px-3 produk-select" required>
                    ${produkOptions}
                </select>
                <input type="number" name="items[${itemIndex}][jumlah]" min="1" value="1" class="w-24 shadow border rounded py-2 px-3 jumlah-input" required>
                <button type="button" class="bg-red-500 text-white px-3 py-2 rounded remove-item">×</button>
            `;
            container.appendChild(div);
            itemIndex++;
            updateRemoveButtons();
            calculateTotal();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.produk-item').remove();
                updateRemoveButtons();
                calculateTotal();
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('produk-select') || e.target.classList.contains('jumlah-input') || e
                .target.id === 'daerah') {
                calculateTotal();
            }
        });

        function updateRemoveButtons() {
            const items = document.querySelectorAll('.produk-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-item');
                removeBtn.style.display = items.length > 1 ? 'block' : 'none';
            });
        }

        calculateTotal();
    </script>
</x-app-layout>
