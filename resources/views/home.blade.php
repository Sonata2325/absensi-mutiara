@extends('layouts.app')

@section('content')
    <section class="relative min-h-[80vh] lg:min-h-[90vh] flex items-center justify-center">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1519003722824-194d4455a60c?q=80&w=1920&auto=format&fit=crop">
            <source src="https://videos.pexels.com/video-files/855381/855381-hd_1280_720_25fps.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-6xl font-extrabold leading-tight">
                Menghubungkan Kebahagiaan dari Generasi ke Generasi
            </h1>
            
        </div>

        <div class="absolute bottom-16 left-1/2 -translate-x-1/2 flex items-center gap-6">
            <a href="{{ route('tracking') }}" class="inline-flex items-center justify-center w-48 whitespace-nowrap px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white hover:text-gray-900 transition">Lacak</a>
            <a href="{{ route('order') }}" class="inline-flex items-center justify-center w-48 whitespace-nowrap px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white hover:text-gray-900 transition">Pesan Sekarang</a>
        </div>
    </section>

    <section class="py-16 bg-white" id="services">
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

            

            <!-- Visi Misi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="bg-white p-8 rounded-2xl h-full shadow-lg border-t-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">VISI</h3>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed">Menjadi perusahaan logistik yang dapat dipercaya, diandalkan dan terkemuka di Indonesia</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl h-full shadow-lg border-t-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">MISI</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700 text-lg">
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-primary rounded-full flex-shrink-0"></div>
                            Kepuasan pelanggan adalah prioritas utama
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-primary rounded-full flex-shrink-0"></div>
                            Membangun tenaga kerja yang profesional dan beretika dalam hal berkendara
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1.5 w-2 h-2 bg-primary rounded-full flex-shrink-0"></div>
                            Menjalin hubungan komunikatif dengan Konsumen maupun Third party sehingga tercipta hubungan bisnis yang harmonis dan berkelanjutan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    

    <!-- Klien Kami Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 uppercase">OUR CLIENTS</h2>
            <div class="mt-2 text-lg text-black font-medium">Dipercayai oleh</div>
            <div class="mt-8"></div>
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
