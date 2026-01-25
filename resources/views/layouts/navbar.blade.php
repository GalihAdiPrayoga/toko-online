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
					{{ config('app.name', 'Toko') }}
				@endauth
			</a>
			<a href="{{ url('/') }}" class="text-sm text-gray-600">Beranda</a>
			@auth
				@if(auth()->user()->role === 'penjual')
					<a href="{{ url('/penjual/dashboard') }}" class="text-sm text-gray-600">Dashboard</a>
				@else
					<a href="{{ url('#orders') }}" class="text-sm text-gray-600">Pesanan</a>
					<a href="{{ url('#wishlist') }}" class="text-sm text-gray-600">Wishlist</a>
				@endif
			@endauth
		</div>

		<div class="flex items-center space-x-4">
			@guest
				<a href="{{ route('login') }}" class="text-sm text-gray-600">Login</a>
				<a href="{{ route('register') }}" class="text-sm text-gray-600">Register</a>
			@else
				<span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="text-sm text-red-600">Logout</button>
				</form>
			@endguest
		</div>
	</div>
</nav>
