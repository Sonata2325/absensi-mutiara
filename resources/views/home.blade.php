@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white py-20 lg:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Warehouse Truck" class="w-full h-full object-cover opacity-30">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Shipments delivered on time <br> with no hassle
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-gray-300">
                Jasa pengiriman barang terpercaya sejak 2003
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('order') }}" class="px-8 py-4 bg-primary hover:bg-blue-800 text-white font-bold rounded-lg text-lg transition shadow-lg">
                    Pesan Pengiriman
                </a>
                <a href="{{ route('tracking') }}" class="px-8 py-4 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold rounded-lg text-lg transition">
                    Lacak Paket
                </a>
            </div>
        </div>
    </section>

    <!-- About Section (Integrated) -->
    <section class="py-20 bg-white" id="about">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="text-sm font-bold text-primary tracking-widest mb-2 uppercase">Tentang Kami</div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Partner Logistik Terpercaya Sejak 2003</h2>
                    <div class="space-y-4 text-gray-700 leading-relaxed text-lg">
                        <p>PT Mutiara Jaya Express berdiri pada 14 Juli 2003 dan bergerak di bidang jasa pengiriman barang. Kami berfokus pada layanan distribusi di wilayah Pulau Jawa, dengan komitmen menjaga ketepatan waktu dan keamanan barang selama proses pengiriman.</p>
                    </div>
                    
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Visi</h3>
                            <p class="text-gray-600">Menjadi perusahaan logistik yang dapat dipercaya, diandalkan dan terkemuka di Indonesia.</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-xl text-gray-900 mb-2">Misi</h3>
                            <ul class="text-gray-600 space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Kepuasan pelanggan prioritas utama
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Tenaga kerja profesional & beretika
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-blue-100 rounded-2xl transform rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=800&q=80" alt="About MJE" class="relative rounded-2xl shadow-xl w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>


    <!-- Layanan Kami Section -->
    <section class="py-20 bg-gray-50" id="services">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Armada Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Pilihan armada lengkap untuk memenuhi segala kebutuhan pengiriman logistik Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Colt Diesel" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Colt Diesel Double</h3>
                        <p class="text-gray-600 mb-4">Tersedia dalam varian Bak Terbuka & Box 3 Pintu. Cocok untuk pengiriman jarak menengah dengan muatan sedang.</p>
                        <a href="{{ route('services') }}" class="text-primary font-semibold hover:underline">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fuso" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Fuso</h3>
                        <p class="text-gray-600 mb-4">Pilihan Bak Terbuka dan Full Box. Solusi efisien untuk muatan berat dan volume besar antar kota.</p>
                        <a href="{{ route('services') }}" class="text-primary font-semibold hover:underline">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1586191582156-ed03f0d06173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tronton" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Tronton</h3>
                        <p class="text-gray-600 mb-4">Varian Bak Terbuka, Full Box & Wingbox. Kapasitas angkut maksimal untuk kebutuhan industri skala besar.</p>
                        <a href="{{ route('services') }}" class="text-primary font-semibold hover:underline">Lihat Detail &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Mengapa Memilih Kami?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Item 1 -->
                <div class="text-center p-6 border rounded-xl hover:border-primary transition">
                    <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Pengiriman Tepat Waktu</h3>
                    <p class="text-gray-600 text-sm">Kami menghargai waktu Anda dengan komitmen jadwal pengiriman yang presisi.</p>
                </div>

                <!-- Item 2 -->
                <div class="text-center p-6 border rounded-xl hover:border-primary transition">
                    <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Armada Lengkap & Terawat</h3>
                    <p class="text-gray-600 text-sm">Seluruh unit kendaraan kami rutin diservis untuk meminimalisir kendala di jalan.</p>
                </div>

                <!-- Item 3 -->
                <div class="text-center p-6 border rounded-xl hover:border-primary transition">
                    <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Driver Profesional</h3>
                    <p class="text-gray-600 text-sm">Supir berpengalaman, terlatih, dan memiliki lisensi lengkap serta beretika.</p>
                </div>

                <!-- Item 4 -->
                <div class="text-center p-6 border rounded-xl hover:border-primary transition">
                    <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Coverage Pulau Jawa</h3>
                    <p class="text-gray-600 text-sm">Jangkauan luas mencakup seluruh kota besar dan area industri di Pulau Jawa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Klien Kami Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Dipercaya Oleh</h2>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Client Placeholders -->
                <div class="text-xl font-bold text-gray-400 flex items-center gap-2">
                    <div class="w-10 h-10 bg-gray-300 rounded"></div> PT. Putra Dumas Lestari
                </div>
                <div class="text-xl font-bold text-gray-400 flex items-center gap-2">
                    <div class="w-10 h-10 bg-gray-300 rounded"></div> PT. Nichias Sunijaya
                </div>
                <div class="text-xl font-bold text-gray-400 flex items-center gap-2">
                    <div class="w-10 h-10 bg-gray-300 rounded"></div> PT. Indofood
                </div>
                <div class="text-xl font-bold text-gray-400 flex items-center gap-2">
                    <div class="w-10 h-10 bg-gray-300 rounded"></div> Mayora
                </div>
            </div>
        </div>
    </section>
@endsection
