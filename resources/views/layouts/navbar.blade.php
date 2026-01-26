<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ url('/') }}" class="text-lg font-semibold">
                @auth
                    @if(auth()->user()->role === 'penjual')
                        Admin Panel
                    @else
                        Toko Online
                    @endif
                @else
                    {{ config('app.name', 'Toko Online') }}
                @endauth
            </a>

            @auth
                @if(auth()->user()->role === 'penjual')
                    <a href="{{ route('penjual.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('penjual.produk.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Produk</a>
                    <a href="{{ route('penjual.transaksi.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Transaksi</a>
                    <a href="{{ route('penjual.laporan.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Laporan</a>
                @else
                    <a href="{{ route('pembeli.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('pembeli.produk.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Produk</a>
                    <a href="{{ route('pembeli.transaksi.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Transaksi</a>
                @endif
            @else
                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900">Beranda</a>
            @endauth
        </div>

        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                <a href="{{ route('register') }}" class="text-sm bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</a>
            @else
                <span class="text-sm text-gray-700">
                    {{ auth()->user()->name }}
                    <span class="text-xs text-gray-500">({{ ucfirst(auth()->user()->role) }})</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
