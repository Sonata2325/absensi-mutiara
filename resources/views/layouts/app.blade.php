<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT Mutiara Jaya Express</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (CDN for immediate usage) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d4ed8', // blue-700
                        secondary: '#9333ea', // purple-600
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 flex flex-col min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-white shadow-md fixed w-full z-50 top-0">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-800 flex items-center gap-2">
                    <!-- Placeholder Logo -->
                    <div class="w-8 h-8 bg-blue-800 text-white flex items-center justify-center rounded">M</div>
                    PT Mutiara Jaya Express
                </a>
            </div>

            <!-- Menu -->
            <nav class="hidden md:flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 font-medium {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }}">Beranda</a>
                <a href="{{ route('services') }}" class="hover:text-blue-600 font-medium {{ request()->routeIs('services') ? 'text-blue-600' : 'text-gray-600' }}">Layanan</a>
                <a href="{{ route('tracking') }}" class="hover:text-blue-600 font-medium {{ request()->routeIs('tracking') ? 'text-blue-600' : 'text-gray-600' }}">Lacak Paket</a>
                <a href="{{ route('order') }}" class="hover:text-blue-600 font-medium {{ request()->routeIs('order') ? 'text-blue-600' : 'text-gray-600' }}">Pesan Sekarang</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-600 font-medium {{ request()->routeIs('contact') ? 'text-blue-600' : 'text-gray-600' }}">Kontak</a>
            </nav>
            
            <!-- Mobile Menu Button (Hamburger) - Implementation skipped for brevity but placeholder here -->
            <button class="md:hidden text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-6" id="contact">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4">PT Mutiara Jaya Express</h3>
                    <p class="text-gray-400 mb-4">Jasa pengiriman barang terpercaya sejak 2003. Melayani distribusi ke seluruh kota besar di Pulau Jawa.</p>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Ruko Jelambar Center</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+62821 1146 4350, +62852 1211 7630</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>ekspedisi_mutiara@yahoo.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Socials & Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan</h3>
                    <div class="flex gap-4 mb-4">
                        <!-- Social placeholders -->
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">F</a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-blue-400 transition">T</a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-pink-600 transition">I</a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} PT Mutiara Jaya Express. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
