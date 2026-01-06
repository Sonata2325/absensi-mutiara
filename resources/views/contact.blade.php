@extends('layouts.app')

@section('content')
    <section class="relative bg-gray-900 text-white py-16 lg:py-24">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1525186402429-b4ff38bedbec?auto=format&fit=crop&w=1920&q=80" alt="Hubungi Kami" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold">Hubungi Kami</h1>
            <p class="mt-3 text-gray-300 max-w-2xl">Tim kami siap membantu Anda</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            @if (session('status'))
                <div class="max-w-5xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border rounded-2xl p-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 font-bold text-gray-900">Alamat Kantor</div>
                    <div class="mt-2 text-gray-700">
                        Ruko Jelambar Center, Blok E41<br>
                        Jl. P. TB. Angke No. 10<br>
                        Jelambar Baru, Jakarta Barat
                    </div>
                    <div class="mt-3">
                        <a href="https://www.google.com/maps/search/?api=1&query=Ruko%20Jelambar%20Center%20Blok%20E41" target="_blank" rel="noopener" class="text-primary font-semibold hover:underline">Buka di Google Maps</a>
                    </div>
                </div>

                <div class="border rounded-2xl p-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 font-bold text-gray-900">Telepon</div>
                    <div class="mt-2 text-gray-700 space-y-1">
                        <div><a href="tel:+6282111464350" class="hover:underline">+62821 1146 4350</a></div>
                        <div><a href="tel:+6285212117630" class="hover:underline">+62852 1211 7630</a></div>
                        <div class="text-sm text-gray-600 mt-2">Jam operasional: Senin-Sabtu 08:00-17:00</div>
                    </div>
                </div>

                <div class="border rounded-2xl p-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 font-bold text-gray-900">Email</div>
                    <div class="mt-2 text-gray-700">
                        <a href="mailto:EKSPEDISI_MUTIARA@YAHOO.COM" class="hover:underline uppercase">EKSPEDISI_MUTIARA@YAHOO.COM</a>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">Response time: 1x24 jam</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white border rounded-2xl p-6 md:p-8 shadow-sm">
                    <div class="text-xl font-bold text-gray-900">Kirim Pesan</div>
                    <form method="POST" action="{{ route('contact.submit') }}" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                            <input name="name" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input name="email" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                            <input name="phone" type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Subjek</label>
                            <input name="subject" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" rows="5" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                        </div>
                        <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Kirim Pesan</button>
                    </form>
                </div>

                <div class="bg-white border rounded-2xl p-6 md:p-8 shadow-sm">
                    <div class="text-xl font-bold text-gray-900">FAQ</div>
                    <div class="mt-6 space-y-3">
                        <details class="border rounded-xl p-4">
                            <summary class="font-semibold text-gray-900 cursor-pointer">Berapa lama estimasi pengiriman?</summary>
                            <div class="mt-2 text-gray-700">Umumnya 1–3 hari kerja untuk area Pulau Jawa, tergantung rute dan jadwal keberangkatan.</div>
                        </details>
                        <details class="border rounded-xl p-4">
                            <summary class="font-semibold text-gray-900 cursor-pointer">Apakah ada tracking real-time?</summary>
                            <div class="mt-2 text-gray-700">Tracking sedang dikembangkan. Untuk saat ini, status pengiriman dikonfirmasi oleh admin melalui kontak yang Anda berikan.</div>
                        </details>
                        <details class="border rounded-xl p-4">
                            <summary class="font-semibold text-gray-900 cursor-pointer">Bagaimana cara pembayaran?</summary>
                            <div class="mt-2 text-gray-700">Pembayaran dan estimasi biaya akan dikonfirmasi oleh admin setelah verifikasi pesanan dan kebutuhan armada.</div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

