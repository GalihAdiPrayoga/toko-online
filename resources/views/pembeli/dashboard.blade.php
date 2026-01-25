@extends('layouts.app')

@section('content')
	<div class="bg-white rounded-lg shadow p-6">
		@auth
			<h3 class="text-lg font-semibold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->name }}</h3>
			<p class="text-gray-600">Anda login sebagai pembeli.</p>
		@else
			<p class="text-gray-600">Silakan login untuk melanjutkan.</p>
		@endauth
	</div>
@endsection
