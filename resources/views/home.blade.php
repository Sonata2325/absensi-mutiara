@extends('layouts.app')

@section('content')
    <section class="relative h-screen flex items-center justify-center">
        <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=1920&auto=format&fit=crop" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <h1 class="text-white font-bold leading-[1.05] tracking-tight">
                <span class="block text-4xl md:text-6xl">Menghubungkan</span>
                <span class="block text-5xl md:text-7xl">Kebahagiaan</span>
                <span class="block text-4xl md:text-6xl">dari Generasi ke Generasi</span>
            </h1>
            <p class="mt-6 text-white/80 text-base md:text-lg max-w-3xl mx-auto">
                Solusi logistik terpercaya untuk distribusi barang di seluruh Pulau Jawa dengan armada profesional dan layanan prima.
            </p>
        </div>

        <div class="absolute bottom-10 left-0 w-full flex flex-col items-center justify-end gap-6 px-4 z-20">
            <div class="flex items-center justify-center gap-3 md:gap-6">
                <a href="{{ route('tracking') }}" class="group relative overflow-hidden inline-flex items-center justify-center w-32 md:w-48 whitespace-nowrap px-4 md:px-8 py-2 md:py-3 text-sm md:text-base rounded-full border border-white/30 bg-white/10 backdrop-blur-md backdrop-saturate-150 text-white shadow-[0_8px_32px_rgba(0,0,0,0.2)] ring-1 ring-white/10 transition duration-300 hover:bg-white hover:text-gray-900 hover:border-white hover:shadow-[0_8px_40px_rgba(255,255,255,0.4)]">
                    <span class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_center,transparent_0%,rgba(255,255,255,0.4)_100%)] opacity-100 transition-opacity duration-300 group-hover:opacity-0"></span>
                    <span class="absolute inset-0 pointer-events-none shadow-[inset_0_0_20px_rgba(255,255,255,0.2)] rounded-full transition-opacity duration-300 group-hover:opacity-0"></span>
                    <span class="relative font-medium tracking-wide">Lacak</span>
                </a>
                <a href="{{ route('order') }}" class="group relative overflow-hidden inline-flex items-center justify-center w-40 md:w-48 whitespace-nowrap px-4 md:px-8 py-2 md:py-3 text-sm md:text-base rounded-full border border-white/30 bg-white/10 backdrop-blur-md backdrop-saturate-150 text-white shadow-[0_8px_32px_rgba(0,0,0,0.2)] ring-1 ring-white/10 transition duration-300 hover:bg-white hover:text-gray-900 hover:border-white hover:shadow-[0_8px_40px_rgba(255,255,255,0.4)]">
                    <span class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_center,transparent_0%,rgba(255,255,255,0.4)_100%)] opacity-100 transition-opacity duration-300 group-hover:opacity-0"></span>
                    <span class="absolute inset-0 pointer-events-none shadow-[inset_0_0_20px_rgba(255,255,255,0.2)] rounded-full transition-opacity duration-300 group-hover:opacity-0"></span>
                    <span class="relative font-medium tracking-wide">Pesan Sekarang</span>
                </a>
            </div>

            <a href="#services" class="text-white/70 hover:text-white transition animate-bounce duration-[2000ms]">
                <svg class="w-6 h-6 md:w-8 md:h-8 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isScrolling = false;
            let lastScrollTop = 0;
            const heroHeight = window.innerHeight;
            const servicesSection = document.getElementById('services');
            
            // Sensitivitas scroll (lebih kecil = lebih sensitif)
            const THRESHOLD = 5; 

            // Handle Wheel (Desktop)
            window.addEventListener('wheel', function(e) {
                if (isScrolling) return;

                const currentScroll = window.scrollY;
                const direction = e.deltaY > 0 ? 'down' : 'up';
                const servicesTop = servicesSection.offsetTop;

                // 1. Dari Hero -> Services (Sensitif & Magnet)
                // Jika user di area Hero (belum sampai services) dan scroll down
                if (direction === 'down' && currentScroll < servicesTop - 100) {
                    if (Math.abs(e.deltaY) > THRESHOLD) {
                        e.preventDefault();
                        isScrolling = true;
                        window.scrollTo({
                            top: servicesTop,
                            behavior: 'smooth'
                        });
                        setTimeout(() => isScrolling = false, 800);
                    }
                }

                // 2. Dari Services -> Hero (Sensitif & Magnet)
                // Jika user tepat di atas Services (toleransi 50px) dan scroll up
                else if (direction === 'up' && Math.abs(currentScroll - servicesTop) < 50) {
                    if (Math.abs(e.deltaY) > THRESHOLD) {
                        e.preventDefault();
                        isScrolling = true;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        setTimeout(() => isScrolling = false, 800);
                    }
                }
                
                // 3. Sisanya: Scroll normal (Services ke bawah bebas)
            }, { passive: false });

            // Handle Touch (Mobile)
            let touchStartY = 0;
            window.addEventListener('touchstart', function(e) {
                touchStartY = e.touches[0].clientY;
            }, { passive: true });

            window.addEventListener('touchmove', function(e) {
                if (isScrolling) return;
                
                const touchEndY = e.touches[0].clientY;
                const deltaY = touchStartY - touchEndY; // positif = swipe up (scroll down)
                const currentScroll = window.scrollY;
                const servicesTop = servicesSection.offsetTop;

                // Logic yang sama untuk Touch
                if (deltaY > THRESHOLD && currentScroll < servicesTop - 100) {
                    // Swipe Up (Scroll Down) di Hero
                    e.preventDefault();
                    isScrolling = true;
                    window.scrollTo({ top: servicesTop, behavior: 'smooth' });
                    setTimeout(() => isScrolling = false, 800);
                } else if (deltaY < -THRESHOLD && Math.abs(currentScroll - servicesTop) < 50) {
                    // Swipe Down (Scroll Up) di Top of Services
                    e.preventDefault();
                    isScrolling = true;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    setTimeout(() => isScrolling = false, 800);
                }
            }, { passive: false });
        });
        </script>
    </section>

    <section class="pt-24 pb-16 bg-white min-h-screen" id="services">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Layanan Kami</h2>
                <p class="mt-2 text-gray-600">Armada dan solusi distribusi untuk kebutuhan pengiriman Anda.</p>
            </div>
            <div id="servicesSlider" class="relative max-w-5xl mx-auto">
                <div class="overflow-hidden rounded-2xl shadow-lg ring-1 ring-black/10 bg-white p-2">
                    <div id="servicesTrack" class="flex transition-transform duration-500 ease-out">
                        <div class="w-full flex-shrink-0">
                            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row items-center">
                                <div class="md:w-1/2 h-80 md:h-96 overflow-hidden relative">
                                    <img src="https://images.unsplash.com/photo-1616432043562-3671ea2e5242?q=80&w=1200&auto=format&fit=crop" alt="Colt Diesel Double" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="md:w-1/2 p-8 md:p-12">
                                    <div class="flex items-center gap-3 mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900">Colt Diesel Double</h3>
                                    </div>
                                    <p class="text-gray-600 text-lg mb-6">Pilihan armada lincah untuk pengiriman cepat.</p>
                                    <div class="flex gap-2">
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Bak Terbuka</span>
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Box 3 Pintu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex-shrink-0">
                            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row-reverse items-center">
                                <div class="md:w-1/2 h-80 md:h-96 overflow-hidden relative">
                                    <img src="https://images.unsplash.com/photo-1591768793355-74d04bb6608f?q=80&w=1200&auto=format&fit=crop" alt="Fuso" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="md:w-1/2 p-8 md:p-12">
                                    <div class="flex items-center gap-3 mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900">Fuso</h3>
                                    </div>
                                    <p class="text-gray-600 text-lg mb-6">Solusi efisien untuk muatan berat dan volume besar.</p>
                                    <div class="flex gap-2">
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Bak Terbuka</span>
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Full Box</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex-shrink-0">
                            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row items-center">
                                <div class="md:w-1/2 h-80 md:h-96 overflow-hidden relative">
                                    <img src="https://images.unsplash.com/photo-1592838064575-70ed626d3a0e?q=80&w=1200&auto=format&fit=crop" alt="Tronton" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="md:w-1/2 p-8 md:p-12">
                                    <div class="flex items-center gap-3 mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900">Tronton</h3>
                                    </div>
                                    <p class="text-gray-600 text-lg mb-6">Kapasitas angkut maksimal untuk kebutuhan industri.</p>
                                    <div class="flex gap-2">
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Bak Terbuka</span>
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Full Box</span>
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">Wingbox</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <div class="flex gap-3">
                        <button id="servicesPrev" class="w-10 h-10 rounded-full border bg-white hover:bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button id="servicesNext" class="w-10 h-10 rounded-full border bg-white hover:bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button class="w-2.5 h-2.5 rounded-full bg-gray-300" data-slide="0"></button>
                        <button class="w-2.5 h-2.5 rounded-full bg-gray-300" data-slide="1"></button>
                        <button class="w-2.5 h-2.5 rounded-full bg-gray-300" data-slide="2"></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var track = document.getElementById('servicesTrack');
            var dots = Array.from(document.querySelectorAll('#servicesSlider [data-slide]'));
            var index = 0;
            function update() {
                track.style.transform = 'translateX(-' + (index * 100) + '%)';
                dots.forEach(function(d,i){ d.classList.toggle('bg-gray-900', i===index); d.classList.toggle('bg-gray-300', i!==index); });
            }
            document.getElementById('servicesPrev').addEventListener('click', function(){ index = (index + dots.length - 1) % dots.length; update(); });
            document.getElementById('servicesNext').addEventListener('click', function(){ index = (index + 1) % dots.length; update(); });
            dots.forEach(function(d,i){ d.addEventListener('click', function(){ index=i; update(); }); });
            update();
            setInterval(function(){ index = (index + 1) % dots.length; update(); }, 3000);
        });
        </script>
    </section>

    <!-- About Section (Integrated) -->
    <section class="pt-8 md:pt-10 pb-16 bg-white" id="about">
        <div class="container mx-auto px-4">
            <div class="relative mb-16">
                <div class="absolute -inset-x-10 top-20 h-72 bg-gradient-to-r from-blue-50 via-white to-blue-50 blur-2xl opacity-80 pointer-events-none"></div>

                <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-10 lg:gap-14 mb-10 max-w-5xl mx-auto">
                    <div class="max-w-2xl">
                        <div class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Kami</div>
                        <div class="mt-3 text-gray-600 text-base md:text-lg">
                            Jasa pengiriman barang terpercaya sejak 2003. Melayani distribusi ke seluruh kota besar di Pulau Jawa dengan armada lengkap dan profesional.
                        </div>
                    </div>

                    <div class="flex items-center gap-4 lg:mt-1">
                        <img src="{{ asset('logopt mutiara.png') }}" alt="Logo PT Mutiara Jaya Express" class="w-16 h-16 md:w-20 md:h-20 object-contain">
                        <div class="text-left leading-tight">
                            <div class="text-lg md:text-xl font-bold text-gray-900">PT Mutiara</div>
                            <div class="text-lg md:text-xl font-bold text-gray-900">Jaya Express</div>
                        </div>
                    </div>
                </div>

                <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6 max-w-5xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 px-5 py-6 text-center">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-primary mb-3">
                            <img src="{{ asset('logoTime.png') }}" alt="Icon Waktu" class="w-9 h-9 object-contain">
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900">20+ Tahun Pengalaman</h3>
                        <p class="mt-2 text-gray-600 text-sm">Berdiri sejak 2003, kami memiliki pengalaman panjang dalam menangani berbagai kebutuhan logistik.</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 px-5 py-6 text-center">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-primary mb-3">
                            <img src="{{ asset('logoEarth.png') }}" alt="Icon Bumi" class="w-9 h-9 object-contain">
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900">Jangkauan Luas</h3>
                        <p class="mt-2 text-gray-600 text-sm">Melayani distribusi ke seluruh kota besar di Pulau Jawa dengan jaringan yang terintegrasi.</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 px-5 py-6 text-center">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-primary mb-3">
                            <img src="{{ asset('logoFast.png') }}" alt="Icon Cepat" class="w-9 h-9 object-contain">
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900">Pengiriman Cepat</h3>
                        <p class="mt-2 text-gray-600 text-sm">Prioritas pada efisiensi waktu loading hingga delivery agar barang tiba tepat waktu.</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 px-5 py-6 text-center">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-primary mb-3">
                            <img src="{{ asset('logoThumbsUp.png') }}" alt="Icon Jempol" class="w-9 h-9 object-contain">
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900">Layanan Terbaik</h3>
                        <p class="mt-2 text-gray-600 text-sm">Mengutamakan kepuasan pelanggan dan profesionalisme kerja yang tinggi.</p>
                    </div>
                </div>
            </div>

            <!-- Visi Misi Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Card Visi -->
                <div class="visi-misi-card relative h-[500px] rounded-3xl overflow-hidden group cursor-pointer shadow-xl">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1000&auto=format&fit=crop" 
                         alt="Visi Background" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 [.active-card_&]:scale-110">
                    
                    <!-- Overlay (Default: Transparent/Gradient, Hover: Black Opacity) -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent group-hover:bg-black/80 [.active-card_&]:bg-black/80 transition-all duration-500"></div>
                    
                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 w-full p-8 md:p-10 flex flex-col justify-end h-full transition-all duration-500">
                        <div class="transform transition-all duration-500 translate-y-[calc(100%-4rem)] group-hover:translate-y-0 [.active-card_&]:translate-y-0">
                            <h3 class="text-4xl font-bold text-white mb-6">VISI</h3>
                            <div class="opacity-0 group-hover:opacity-100 [.active-card_&]:opacity-100 transition-opacity duration-500 delay-100">
                                <p class="text-white text-xl leading-relaxed font-medium">
                                    Menjadi perusahaan logistik yang dapat dipercaya, diandalkan dan terkemuka di Indonesia
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Misi -->
                <div class="visi-misi-card relative h-[500px] rounded-3xl overflow-hidden group cursor-pointer shadow-xl">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=1000&auto=format&fit=crop" 
                         alt="Misi Background" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 [.active-card_&]:scale-110">
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent group-hover:bg-black/80 [.active-card_&]:bg-black/80 transition-all duration-500"></div>
                    
                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 w-full p-8 md:p-10 flex flex-col justify-end h-full transition-all duration-500">
                        <div class="transform transition-all duration-500 translate-y-[calc(100%-4rem)] group-hover:translate-y-0 [.active-card_&]:translate-y-0">
                            <h3 class="text-4xl font-bold text-white mb-6">MISI</h3>
                            <div class="opacity-0 group-hover:opacity-100 [.active-card_&]:opacity-100 transition-opacity duration-500 delay-100">
                                <ul class="space-y-4 text-white text-lg">
                                    <li class="flex items-start gap-3">
                                        <div class="mt-2 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                        <span>Kepuasan pelanggan adalah prioritas utama</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="mt-2 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                        <span>Membangun tenaga kerja yang profesional dan beretika</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="mt-2 w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                        <span>Menjalin hubungan bisnis yang harmonis dan berkelanjutan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Observer untuk Visi Misi Cards
        const observerOptions = {
            threshold: 0.6 // Trigger saat 60% elemen terlihat
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const card = entry.target;
                
                if (entry.isIntersecting) {
                    // Jika belum ada timer berjalan, set timer
                    if (!card.dataset.timer) {
                        card.dataset.timer = setTimeout(() => {
                            card.classList.add('active-card');
                            card.dataset.timer = ''; // Clear flag tapi biarkan properti ada
                        }, 750); // Delay 0.75 detik
                    }
                } else {
                    // Jika keluar view, cancel timer jika ada
                    if (card.dataset.timer) {
                        clearTimeout(parseInt(card.dataset.timer));
                        card.dataset.timer = '';
                    }
                    // Opsional: Hapus class active saat keluar view agar bisa trigger lagi nanti
                    card.classList.remove('active-card');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.visi-misi-card').forEach(card => {
            observer.observe(card);
        });
    });
    </script>


    

    <!-- Klien Kami Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 uppercase">OUR CLIENTS</h2>
            <div class="mt-2 text-lg text-black font-medium">Dipercayai oleh</div>
            <div class="mt-8"></div>
            <div class="flex flex-nowrap justify-center items-center gap-10 md:gap-14 overflow-x-auto py-2">
                <div class="shrink-0 w-32 md:w-40 h-16 md:h-20 flex items-center justify-center">
                    <img src="{{ asset('logodumas.png') }}" alt="Logo Dumas" class="max-w-full max-h-full object-contain">
                </div>
                <div class="shrink-0 w-32 md:w-40 h-16 md:h-20 flex items-center justify-center">
                    <img src="{{ asset('logoGeosinindo.png') }}" alt="Logo Geosinindo" class="max-w-full max-h-full object-contain">
                </div>
                <div class="shrink-0 w-32 md:w-40 h-16 md:h-20 flex items-center justify-center">
                    <img src="{{ asset('logoNichiasRockwool.png') }}" alt="Logo Nichias Rockwool" class="max-w-full max-h-full object-contain scale-125">
                </div>
                <div class="shrink-0 w-32 md:w-40 h-16 md:h-20 flex items-center justify-center">
                    <img src="{{ asset('logoPTNichias.png') }}" alt="Logo PT Nichias" class="max-w-full max-h-full object-contain">
                </div>
                <div class="shrink-0 w-32 md:w-40 h-16 md:h-20 flex items-center justify-center">
                    <img src="{{ asset('logoPTGeostructure.png') }}" alt="Logo PT Geostructure" class="max-w-full max-h-full object-contain">
                </div>
            </div>
        </div>
    </section>



@endsection
