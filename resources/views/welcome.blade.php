<!-- filepath: c:\laragon\www\toko-online\resources\views\welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Toko Online') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Toko Online</h1>
                <div class="space-x-4">
                    @auth
                        @if(auth()->user()->role === 'penjual')
                            <a href="{{ route('penjual.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        @else
                            <a href="{{ route('pembeli.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">
                    Selamat Datang di <span class="text-blue-600">Toko Online</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Platform jual beli online terpercaya dengan berbagai produk berkualitas dan harga terbaik.
                </p>

                @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold border-2 border-blue-600 hover:bg-blue-50 transition">
                        Masuk
                    </a>
                </div>
                @else
                <div>
                    @if(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Ke Dashboard Penjual
                        </a>
                    @else
                        <a href="{{ route('pembeli.produk.index') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Mulai Belanja
                        </a>
                    @endif
                </div>
                @endguest
            </div>
        </div>

        <!-- Features -->
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-4">🛒</div>
                    <h3 class="text-xl font-semibold mb-2">Belanja Mudah</h3>
                    <p class="text-gray-600">Proses belanja yang simpel dan cepat</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-4">🚚</div>
                    <h3 class="text-xl font-semibold mb-2">Pengiriman Cepat</h3>
                    <p class="text-gray-600">Kirim ke seluruh Indonesia</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="text-xl font-semibold mb-2">Pembayaran Aman</h3>
                    <p class="text-gray-600">Berbagai metode pembayaran tersedia</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Toko Online. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
