@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white py-20 lg:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Logistic Truck" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Mitra Logistik Terpercaya <br> dan Andal
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-gray-300">
                Solusi Distribusi Terbaik untuk Bisnis Anda
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
            <!-- Tentang Kami Content -->
            <div class="mb-16">
                <div class="text-sm font-bold text-primary tracking-widest mb-2 uppercase text-center">TENTANG KAMI</div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">PT Mutiara Jaya Express</h2>
                <div class="max-w-4xl mx-auto text-gray-700 leading-relaxed text-lg space-y-6 text-justify">
                    <p>PT Mutiara Jaya Express berdiri pada 14 Juli 2003 yang bergerak dalam bidang jasa pengiriman barang dengan menjunjung tinggi tanggung jawab dan profesionalisme dalam bekerja.</p>
                    <p>Pesatnya perkembangan industri di Indonesia membuat kami hadir untuk melayani dan melengkapi pelaku usaha dalam pendistribusian langsung baik hasil produksi maupun sebagai forwarder kepada seluruh konsumen yang tersebar diseluruh kota-kota besar yang ada di Indonesia, terutama Wilayah Pulau Jawa.</p>
                    <p>Permintaan pasar yang sangat dinamis memaksa pelaku usaha untuk bergerak cepat baik dalam hal produksi maupun distribusi.</p>
                    <p>Hal ini yang mendasari PT Mutiara Jaya Express untuk hadir dan menawarkan jasa pengiriman barang secara profesional dan menjunjung tinggi efisiensi dalam hal loading time hingga delivery time, serta Cost of Delivery.</p>
                    <p>PT Mutiara Jaya Express juga memiliki moto sebagai pedoman yaitu "Shipments delivered on time with no hassle" dimana kami berkomitmen untuk memberikan layanan terbaik yang berdasar pada hubungan baik antara kami dan klien.</p>
                </div>
            </div>

            <!-- Legalitas -->
            <div class="max-w-6xl mx-auto mb-16">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-bold text-gray-900">Legalitas Kami</h3>
                    <div class="w-20 h-1 bg-primary mx-auto mt-2 rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center text-center border border-gray-100 group">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Direktur Utama</h4>
                        <p class="text-gray-600 font-medium">H Purwoko</p>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center text-center border border-gray-100 group">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Notaris</h4>
                        <p class="text-gray-600 font-medium">Yanti Jacline Jennifer Tobing, S.H., M.Kn.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center text-center border border-gray-100 group">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary group-hover:bg-primary group-hover:text-white transition duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">No SK Menkumham</h4>
                        <p class="text-gray-600 font-medium">AHU-0040073.AH.01.02.Tahun 2022</p>
                    </div>
                </div>
            </div>

            <!-- Visi Misi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="bg-white p-8 rounded-2xl h-full shadow-lg border-t-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center font-bold text-xl shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">VISI</h3>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed">Menjadi perusahaan logistik yang dapat dipercaya, diandalkan dan terkemuka di Indonesia</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl h-full shadow-lg border-t-4 border-secondary">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-secondary text-white rounded-lg flex items-center justify-center font-bold text-xl shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">MISI</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700 text-lg">
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-secondary rounded-full flex-shrink-0"></div>
                            Kepuasan pelanggan adalah prioritas utama
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-secondary rounded-full flex-shrink-0"></div>
                            Membangun tenaga kerja yang profesional dan beretika dalam hal berkendara
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-secondary rounded-full flex-shrink-0"></div>
                            Menjalin hubungan komunikatif dengan Konsumen maupun Third party sehingga tercipta hubungan bisnis yang harmonis dan berkelanjutan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <!-- Layanan Kami Section -->
    <section class="py-20 bg-gray-50" id="services">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 uppercase">Layanan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    PT Mutiara Jaya Express melayani jasa distribusi barang melalui jalur darat ke seluruh kota besar di wilayah Pulau Jawa, dengan transportasi yang kami miliki diantaranya:
                </p>
            </div>

            <div class="max-w-5xl mx-auto space-y-8">
                <!-- Card 1: Colt Diesel -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col md:flex-row items-center group">
                    <div class="md:w-1/2 h-64 md:h-80 overflow-hidden relative">
                        <div class="absolute inset-0 bg-blue-900 opacity-0 group-hover:opacity-10 transition duration-300 z-10"></div>
                        <!-- Colt Diesel (Small truck, usually yellow/light) -->
                        <img src="https://images.unsplash.com/photo-1616432043562-3671ea2e5242?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Colt Diesel Double" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="md:w-1/2 p-8 md:p-12 text-left">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Colt Diesel Double</h3>
                        </div>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Pilihan armada lincah untuk pengiriman cepat. Tersedia dalam varian:
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Bak Terbuka
                            </li>
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Box 3 Pintu
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 2: Fuso -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col md:flex-row-reverse items-center group">
                    <div class="md:w-1/2 h-64 md:h-80 overflow-hidden relative">
                         <div class="absolute inset-0 bg-blue-900 opacity-0 group-hover:opacity-10 transition duration-300 z-10"></div>
                        <!-- Fuso (Medium truck, usually orange) -->
                        <img src="https://images.unsplash.com/photo-1591768793355-74d04bb6608f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fuso Truck" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="md:w-1/2 p-8 md:p-12 text-left">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Fuso</h3>
                        </div>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Solusi efisien untuk muatan berat dan volume besar antar kota.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Bak Terbuka
                            </li>
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Full Box
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 3: Tronton -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col md:flex-row items-center group">
                    <div class="md:w-1/2 h-64 md:h-80 overflow-hidden relative">
                         <div class="absolute inset-0 bg-blue-900 opacity-0 group-hover:opacity-10 transition duration-300 z-10"></div>
                        <!-- Tronton (Large long truck, wingbox) -->
                        <img src="https://images.unsplash.com/photo-1592838064575-70ed626d3a0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tronton Wingbox" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="md:w-1/2 p-8 md:p-12 text-left">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Tronton</h3>
                        </div>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Kapasitas angkut maksimal untuk kebutuhan industri skala besar.
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Bak Terbuka
                            </li>
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Full Box
                            </li>
                            <li class="flex items-center gap-2 text-gray-700 font-medium">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Wingbox
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Klien Kami Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 uppercase">Klien Kami</h2>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Putra Dumas Lestari</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Nichias Sunijaya</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Nichias Rockwool Indonesia</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Kartika Agrapuspa</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Saritunggal Mandirikarsa</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Geostructure Dynamics</div>
                <div class="text-lg font-semibold text-gray-600 border px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">PT. Tetrasa Geosinindo</div>
            </div>
        </div>
    </section>

@endsection
