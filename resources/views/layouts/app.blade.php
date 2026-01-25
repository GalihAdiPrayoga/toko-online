<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @include('layouts.navbar')
            <!-- Page Content -->
            <main class="flex-1">
                @auth
                    @if(auth()->user()->role === 'penjual')
                        <!-- Penjual Layout: Sidebar + Content -->
                        <div class="flex">
                            @include('layouts.sidebar')
                            <div class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                                @yield('content')
                            </div>
                        </div>
                    @else
                        <!-- Pembeli Layout: Full Width Content -->
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @yield('content')
                        </div>
                    @endif
                @else
                    <!-- Guest Layout: Full Width Content -->
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                @endauth
            </main>

            @auth
                @if(auth()->user()->role !== 'penjual')
                    @include('layouts.footer-pembeli')
                @endif
            @else
                @include('layouts.footer-pembeli')
            @endauth
        </div>
    </body>
</html>
