@extends('layouts.app')

@section('content')
    <section class="relative bg-gray-900 text-white py-16 lg:py-24">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1590005354167-6da97870c757?auto=format&fit=crop&w=1920&q=80" alt="Layanan Pengiriman" class="w-full h-full object-cover opacity-25">
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold">Layanan Pengiriman Kami</h1>
            <p class="mt-3 text-gray-300 max-w-2xl">Melayani distribusi ke seluruh kota besar di Pulau Jawa.</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Jenis Armada</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">Pilih armada sesuai kebutuhan muatan dan karakter barang Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 border rounded-2xl overflow-hidden shadow-sm">
                    <div class="h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1200&q=80" alt="Colt Diesel Double" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">Colt Diesel Double</h3>
                        <div class="mt-4 space-y-2 text-gray-700">
                            <div class="flex gap-2">
                                <span class="font-semibold">Spesifikasi:</span>
                                <span>Bak terbuka & Box 3 pintu</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Kapasitas:</span>
                                <span>Muatan menengah</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Cocok untuk:</span>
                                <span>Produk retail, furniture, barang palet</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border rounded-2xl overflow-hidden shadow-sm">
                    <div class="h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=1200&q=80" alt="Fuso" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">Fuso</h3>
                        <div class="mt-4 space-y-2 text-gray-700">
                            <div class="flex gap-2">
                                <span class="font-semibold">Spesifikasi:</span>
                                <span>Bak terbuka dan Full box</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Kapasitas:</span>
                                <span>Muatan berat</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Cocok untuk:</span>
                                <span>Material produksi, distribusi antar kota</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border rounded-2xl overflow-hidden shadow-sm">
                    <div class="h-52 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1586191582156-ed03f0d06173?auto=format&fit=crop&w=1200&q=80" alt="Tronton" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">Tronton</h3>
                        <div class="mt-4 space-y-2 text-gray-700">
                            <div class="flex gap-2">
                                <span class="font-semibold">Spesifikasi:</span>
                                <span>Bak terbuka, Full box & Wingbox</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Kapasitas:</span>
                                <span>Muatan paling besar</span>
                            </div>
                            <div class="flex gap-2">
                                <span class="font-semibold">Cocok untuk:</span>
                                <span>Barang volume besar dan kebutuhan industri</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Jenis Layanan</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">Skema pengiriman fleksibel untuk kebutuhan bisnis maupun pelanggan akhir.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white border rounded-2xl p-8 shadow-sm">
                    <div class="text-sm font-semibold text-primary mb-2">B2B</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Business to Business</h3>
                    <p class="text-gray-700 leading-relaxed">Pengiriman dari gudang/pabrik ke gudang/pabrik.</p>
                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <div class="border rounded-xl p-4">
                            <div class="font-semibold text-gray-900">Fitur</div>
                            <div class="text-gray-700">Pickup dari lokasi pengirim</div>
                        </div>
                        <div class="border rounded-xl p-4">
                            <div class="font-semibold text-gray-900">Proses</div>
                            <div class="text-gray-700">Koordinasi jadwal, konfirmasi ketersediaan driver</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border rounded-2xl p-8 shadow-sm">
                    <div class="text-sm font-semibold text-primary mb-2">B2C</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Business to Consumer</h3>
                    <p class="text-gray-700 leading-relaxed">Pengiriman dari kantor MJE ke alamat tujuan.</p>
                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <div class="border rounded-xl p-4">
                            <div class="font-semibold text-gray-900">Fitur</div>
                            <div class="text-gray-700">Drop barang di kantor MJE terdekat</div>
                        </div>
                        <div class="border rounded-xl p-4">
                            <div class="font-semibold text-gray-900">Proses</div>
                            <div class="text-gray-700">Langsung diproses tanpa waiting pickup</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Coverage Area</h2>
                    <p class="mt-3 text-gray-600">Jangkauan pengiriman mencakup kota-kota besar dan area industri di Pulau Jawa.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['Jakarta', 'Bekasi', 'Tangerang', 'Bogor', 'Bandung', 'Cirebon', 'Semarang', 'Yogyakarta', 'Solo', 'Surabaya', 'Malang'] as $city)
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-primary text-sm font-medium">{{ $city }}</span>
                        @endforeach
                    </div>
                    <div class="mt-6 border rounded-2xl p-6 bg-gray-50">
                        <div class="font-semibold text-gray-900">Estimasi Waktu</div>
                        <div class="mt-2 text-gray-700">Umumnya 1–3 hari kerja (tergantung rute, jarak, dan jadwal keberangkatan).</div>
                    </div>
                </div>

                <div class="bg-gray-50 border rounded-2xl p-6">
                    <div class="h-80 rounded-xl bg-white border flex items-center justify-center text-gray-500">
                        Peta coverage area (opsional)
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        Jika ingin menampilkan peta, bisa integrasi dengan Leaflet + OpenStreetMap tanpa biaya lisensi.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold">Siap Mengirim Barang?</h2>
                    <p class="mt-2 text-gray-300">Hubungi tim kami untuk jadwal pickup, ketersediaan armada, dan estimasi biaya.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('order') }}" class="px-6 py-3 bg-primary hover:bg-blue-800 text-white font-bold rounded-lg transition">Pesan Sekarang</a>
                    <a href="{{ route('home') }}#tracking" class="px-6 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 font-bold rounded-lg transition">Lacak Paket</a>
                </div>
            </div>
        </div>
    </section>
@endsection
