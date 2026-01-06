@extends('layouts.app')

@section('content')
    <section class="bg-gray-900 text-white py-12 lg:py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col gap-3">
                <h1 class="text-2xl md:text-4xl font-bold">Buat Pesanan Pengiriman</h1>
                <p class="text-gray-300 max-w-2xl">Pilih jenis layanan yang Anda butuhkan, isi detail pengiriman, lalu konfirmasi pesanan.</p>
            </div>
        </div>
    </section>

    <section class="py-10 bg-gray-50">
        <div class="container mx-auto px-4">
            @if (session('status'))
                <div class="max-w-5xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="max-w-5xl mx-auto">
                <div class="bg-white border rounded-2xl p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold text-primary" id="orderStepLabel">Step 1 of 3</div>
                                <div class="text-gray-800 font-bold text-lg" id="orderStepTitle">Pilih Jenis Layanan</div>
                                <div class="text-gray-600 mt-1" id="orderStepSubtitle">Pilih jenis layanan yang Anda butuhkan</div>
                            </div>
                            <div class="hidden sm:flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary" id="dot1"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-300" id="dot2"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-300" id="dot3"></div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-primary h-2 rounded-full transition-all" style="width: 33%" id="orderProgress"></div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div id="step1">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <button type="button" class="text-left bg-gray-50 border rounded-2xl p-6 hover:border-primary hover:bg-white transition" id="chooseB2B">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center font-bold">B2B</div>
                                        <div class="flex-1">
                                            <div class="text-xl font-bold text-gray-900">B2B (Business to Business)</div>
                                            <div class="mt-2 text-gray-700">Pengiriman dari lokasi Anda ke alamat tujuan. Driver akan pickup barang di lokasi Anda.</div>
                                            <div class="mt-4 space-y-2 text-gray-700">
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Pickup di lokasi pengirim</span></div>
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Cocok untuk volume besar</span></div>
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Jadwal fleksibel</span></div>
                                            </div>
                                            <div class="mt-6">
                                                <span class="inline-flex items-center px-4 py-2 bg-primary text-white font-semibold rounded-lg">Pilih B2B</span>
                                            </div>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="text-left bg-gray-50 border rounded-2xl p-6 hover:border-primary hover:bg-white transition" id="chooseB2C">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-primary flex items-center justify-center font-bold">B2C</div>
                                        <div class="flex-1">
                                            <div class="text-xl font-bold text-gray-900">B2C (Business to Consumer)</div>
                                            <div class="mt-2 text-gray-700">Kirim barang dari kantor MJE terdekat ke alamat tujuan. Anda perlu drop barang ke kantor kami.</div>
                                            <div class="mt-4 space-y-2 text-gray-700">
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Proses lebih cepat</span></div>
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Cocok untuk paket kecil-menengah</span></div>
                                                <div class="flex gap-2"><span class="text-primary font-bold">✓</span><span>Tidak perlu menunggu pickup</span></div>
                                            </div>
                                            <div class="mt-6">
                                                <span class="inline-flex items-center px-4 py-2 bg-primary text-white font-semibold rounded-lg">Pilih B2C</span>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div id="step2" class="hidden">
                            <form method="POST" action="{{ route('order.submit') }}" id="orderForm" class="space-y-8">
                                @csrf
                                <input type="hidden" name="service_type" id="service_type">

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="bg-gray-50 border rounded-2xl p-6">
                                        <div class="flex items-center justify-between">
                                            <div class="font-bold text-gray-900">Informasi Pengirim</div>
                                            <span class="text-xs font-semibold px-2 py-1 rounded bg-blue-100 text-primary" id="serviceBadge">B2B</span>
                                        </div>

                                        <div class="mt-5 space-y-4" id="senderB2B">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Perusahaan/Pengirim</label>
                                                    <input name="sender_company" id="sender_company" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kontak Person</label>
                                                    <input name="sender_contact" id="sender_contact" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                                    <input name="sender_phone" id="sender_phone" type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                                    <input name="sender_email" id="sender_email" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pickup Lengkap</label>
                                                <textarea name="pickup_address" id="pickup_address" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jadwal Pickup yang Diinginkan</label>
                                                    <input name="pickup_schedule" id="pickup_schedule" type="datetime-local" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan untuk Pickup</label>
                                                    <input name="pickup_note" id="pickup_note" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 space-y-4 hidden" id="senderB2C">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pengirim</label>
                                                    <input name="sender_name" id="sender_name" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                                    <input name="sender_phone_b2c" id="sender_phone_b2c" type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                                <input name="sender_email_b2c" id="sender_email_b2c" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kantor MJE Terdekat</label>
                                                <select name="office_id" id="office_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                    <option value="">Pilih kantor</option>
                                                    <option value="jelambar">Kantor Pusat - Jelambar</option>
                                                    <option value="bandung">Bandung</option>
                                                    <option value="surabaya">Surabaya</option>
                                                </select>
                                            </div>
                                            <div class="bg-white border rounded-xl p-4 hidden" id="officeInfo">
                                                <div class="font-semibold text-gray-900" id="officeName"></div>
                                                <div class="mt-1 text-gray-700" id="officeAddress"></div>
                                                <div class="mt-2 text-sm text-gray-600" id="officeHours"></div>
                                                <div class="mt-1 text-sm text-gray-600" id="officeContact"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 border rounded-2xl p-6">
                                        <div class="font-bold text-gray-900">Informasi Penerima</div>
                                        <div class="mt-5 space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                                                <input name="receiver_name" id="receiver_name" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon Penerima</label>
                                                <input name="receiver_phone" id="receiver_phone" type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Tujuan Lengkap</label>
                                                <textarea name="receiver_address" id="receiver_address" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan untuk Penerima</label>
                                                <input name="receiver_note" id="receiver_note" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 border rounded-2xl p-6">
                                    <div class="font-bold text-gray-900">Informasi Barang</div>
                                    <div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                                                <textarea name="item_description" id="item_description" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Berat Estimasi (kg)</label>
                                                    <input name="item_weight_kg" id="item_weight_kg" type="number" min="0" step="0.1" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                                </div>
                                                <div class="flex items-center gap-3 mt-7 md:mt-0">
                                                    <label class="inline-flex items-center gap-2 text-gray-700 font-semibold">
                                                        <input name="item_fragile" id="item_fragile" type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded">
                                                        Barang fragile/mudah pecah?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Dimensi (cm)</label>
                                                <div class="grid grid-cols-3 gap-3">
                                                    <input name="item_length_cm" id="item_length_cm" type="number" min="0" step="1" placeholder="Panjang" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                    <input name="item_width_cm" id="item_width_cm" type="number" min="0" step="1" placeholder="Lebar" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                    <input name="item_height_cm" id="item_height_cm" type="number" min="0" step="1" placeholder="Tinggi" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Armada yang Dibutuhkan</label>
                                                <select name="fleet_type" id="fleet_type" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                    <option value="">Pilih armada</option>
                                                    <option value="colt_diesel_double">Colt Diesel Double</option>
                                                    <option value="fuso">Fuso</option>
                                                    <option value="tronton">Tronton</option>
                                                    <option value="recommendation">Tidak Tahu / Minta Rekomendasi</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Khusus</label>
                                                <textarea name="item_note" id="item_note" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-3 justify-between items-center">
                                    <button type="button" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition" id="backToStep1">Kembali</button>
                                    <button type="button" class="px-8 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition" id="goToReview">Lanjut ke Review</button>
                                </div>
                            </form>
                        </div>

                        <div id="step3" class="hidden">
                            <div class="space-y-6">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Review Pesanan Anda</h2>
                                    <p class="text-gray-600 mt-1">Pastikan semua informasi sudah benar sebelum submit.</p>
                                </div>

                                <div class="bg-gray-50 border rounded-2xl p-6 space-y-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500">Jenis Layanan</div>
                                            <div class="font-bold text-gray-900" id="reviewServiceType">-</div>
                                        </div>
                                        <button type="button" class="text-primary font-semibold hover:underline" id="editService">Ubah</button>
                                    </div>

                                    <div class="border-t pt-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-500">Detail Pengirim</div>
                                                <div class="mt-2 text-gray-900 whitespace-pre-line" id="reviewSender">-</div>
                                            </div>
                                            <button type="button" class="text-primary font-semibold hover:underline" id="editStep2Sender">Edit</button>
                                        </div>
                                    </div>

                                    <div class="border-t pt-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-500">Detail Penerima</div>
                                                <div class="mt-2 text-gray-900 whitespace-pre-line" id="reviewReceiver">-</div>
                                            </div>
                                            <button type="button" class="text-primary font-semibold hover:underline" id="editStep2Receiver">Edit</button>
                                        </div>
                                    </div>

                                    <div class="border-t pt-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-500">Detail Barang</div>
                                                <div class="mt-2 text-gray-900 whitespace-pre-line" id="reviewItem">-</div>
                                            </div>
                                            <button type="button" class="text-primary font-semibold hover:underline" id="editStep2Item">Edit</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white border rounded-2xl p-6">
                                    <div class="font-bold text-gray-900">Syarat & Ketentuan</div>
                                    <div class="mt-3 flex items-start gap-3">
                                        <input type="checkbox" id="termsCheck" class="mt-1 w-4 h-4 text-primary border-gray-300 rounded">
                                        <label for="termsCheck" class="text-gray-700">
                                            Saya setuju dengan syarat dan ketentuan PT Mutiara Jaya Express
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="text-primary font-semibold hover:underline" id="openTerms">Lihat Syarat & Ketentuan</button>
                                    </div>
                                </div>

                                <div class="bg-gray-50 border rounded-2xl p-6">
                                    <div class="font-bold text-gray-900">Estimasi Biaya</div>
                                    <div class="mt-2 text-gray-700">Estimasi biaya akan dikonfirmasi oleh admin kami.</div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-3 justify-between items-center">
                                    <button type="button" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition" id="backToStep2">Kembali</button>
                                    <button type="button" class="px-8 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition" id="submitOrderBtn">Submit Pesanan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4" id="termsModal">
                    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b flex items-center justify-between">
                            <div class="font-bold text-gray-900">Syarat & Ketentuan</div>
                            <button type="button" class="text-gray-600 hover:text-gray-900 font-semibold" id="closeTerms">Tutup</button>
                        </div>
                        <div class="p-6 space-y-3 text-gray-700 leading-relaxed">
                            <div>1. Data pesanan akan diverifikasi oleh admin sebelum penjemputan/pengiriman.</div>
                            <div>2. Estimasi biaya dan jadwal final mengikuti konfirmasi admin dan ketersediaan armada.</div>
                            <div>3. Pastikan alamat dan nomor kontak dapat dihubungi untuk mempercepat proses.</div>
                        </div>
                        <div class="px-6 py-4 border-t flex justify-end">
                            <button type="button" class="px-6 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-blue-800 transition" id="agreeTerms">Saya Mengerti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');

            const orderStepLabel = document.getElementById('orderStepLabel');
            const orderStepTitle = document.getElementById('orderStepTitle');
            const orderStepSubtitle = document.getElementById('orderStepSubtitle');
            const orderProgress = document.getElementById('orderProgress');

            const dot1 = document.getElementById('dot1');
            const dot2 = document.getElementById('dot2');
            const dot3 = document.getElementById('dot3');

            const chooseB2B = document.getElementById('chooseB2B');
            const chooseB2C = document.getElementById('chooseB2C');

            const serviceTypeInput = document.getElementById('service_type');
            const serviceBadge = document.getElementById('serviceBadge');
            const senderB2B = document.getElementById('senderB2B');
            const senderB2C = document.getElementById('senderB2C');

            const backToStep1 = document.getElementById('backToStep1');
            const goToReview = document.getElementById('goToReview');
            const backToStep2 = document.getElementById('backToStep2');
            const submitOrderBtn = document.getElementById('submitOrderBtn');
            const orderForm = document.getElementById('orderForm');

            const reviewServiceType = document.getElementById('reviewServiceType');
            const reviewSender = document.getElementById('reviewSender');
            const reviewReceiver = document.getElementById('reviewReceiver');
            const reviewItem = document.getElementById('reviewItem');

            const editService = document.getElementById('editService');
            const editStep2Sender = document.getElementById('editStep2Sender');
            const editStep2Receiver = document.getElementById('editStep2Receiver');
            const editStep2Item = document.getElementById('editStep2Item');

            const termsCheck = document.getElementById('termsCheck');
            const termsModal = document.getElementById('termsModal');
            const openTerms = document.getElementById('openTerms');
            const closeTerms = document.getElementById('closeTerms');
            const agreeTerms = document.getElementById('agreeTerms');

            const officeSelect = document.getElementById('office_id');
            const officeInfo = document.getElementById('officeInfo');
            const officeName = document.getElementById('officeName');
            const officeAddress = document.getElementById('officeAddress');
            const officeHours = document.getElementById('officeHours');
            const officeContact = document.getElementById('officeContact');

            const offices = {
                jelambar: {
                    name: 'Kantor Pusat - Jelambar',
                    address: 'Ruko Jelambar Center, Jakarta Barat',
                    hours: 'Jam operasional: Senin–Jumat 08:00–17:00',
                    contact: 'Contact: +62 821 1146 4350'
                },
                bandung: {
                    name: 'Kantor Bandung',
                    address: 'Bandung, Jawa Barat',
                    hours: 'Jam operasional: Senin–Jumat 08:00–17:00',
                    contact: 'Contact: +62 852 1211 7630'
                },
                surabaya: {
                    name: 'Kantor Surabaya',
                    address: 'Surabaya, Jawa Timur',
                    hours: 'Jam operasional: Senin–Jumat 08:00–17:00',
                    contact: 'Contact: +62 852 1211 7630'
                }
            };

            let currentStep = 1;
            let serviceType = null;

            function setDots(step) {
                const active = 'bg-primary';
                const inactive = 'bg-gray-300';
                dot1.className = dot1.className.replace(active, inactive);
                dot2.className = dot2.className.replace(active, inactive);
                dot3.className = dot3.className.replace(active, inactive);

                if (step >= 1) dot1.className = dot1.className.replace(inactive, active);
                if (step >= 2) dot2.className = dot2.className.replace(inactive, active);
                if (step >= 3) dot3.className = dot3.className.replace(inactive, active);
            }

            function setStep(step) {
                currentStep = step;
                step1.classList.toggle('hidden', step !== 1);
                step2.classList.toggle('hidden', step !== 2);
                step3.classList.toggle('hidden', step !== 3);

                setDots(step);
                orderStepLabel.textContent = `Step ${step} of 3`;

                if (step === 1) {
                    orderStepTitle.textContent = 'Pilih Jenis Layanan';
                    orderStepSubtitle.textContent = 'Pilih jenis layanan yang Anda butuhkan';
                    orderProgress.style.width = '33%';
                } else if (step === 2) {
                    orderStepTitle.textContent = 'Isi Form Pengiriman';
                    orderStepSubtitle.textContent = 'Lengkapi informasi pengirim, penerima, dan barang';
                    orderProgress.style.width = '66%';
                } else {
                    orderStepTitle.textContent = 'Review & Konfirmasi';
                    orderStepSubtitle.textContent = 'Pastikan semua informasi sudah benar sebelum submit';
                    orderProgress.style.width = '100%';
                }
            }

            function applyServiceType(type) {
                serviceType = type;
                serviceTypeInput.value = type;
                serviceBadge.textContent = type.toUpperCase();

                senderB2B.classList.toggle('hidden', type !== 'b2b');
                senderB2C.classList.toggle('hidden', type !== 'b2c');

                const b2bRequired = [
                    'sender_company',
                    'sender_contact',
                    'sender_phone',
                    'sender_email',
                    'pickup_address'
                ];
                const b2cRequired = [
                    'sender_name',
                    'sender_phone_b2c',
                    'sender_email_b2c',
                    'office_id'
                ];

                b2bRequired.forEach((id) => {
                    const el = document.getElementById(id);
                    if (el) el.required = type === 'b2b';
                });
                b2cRequired.forEach((id) => {
                    const el = document.getElementById(id);
                    if (el) el.required = type === 'b2c';
                });
            }

            function toMultiline(lines) {
                return lines.filter(Boolean).join('\n');
            }

            function formatReview() {
                const fd = new FormData(orderForm);

                reviewServiceType.textContent = serviceType ? serviceType.toUpperCase() : '-';

                const senderLines = [];
                if (serviceType === 'b2b') {
                    senderLines.push(`Perusahaan/Pengirim: ${fd.get('sender_company') || '-'}`);
                    senderLines.push(`Kontak Person: ${fd.get('sender_contact') || '-'}`);
                    senderLines.push(`Telepon: ${fd.get('sender_phone') || '-'}`);
                    senderLines.push(`Email: ${fd.get('sender_email') || '-'}`);
                    senderLines.push(`Alamat Pickup: ${fd.get('pickup_address') || '-'}`);
                    senderLines.push(`Jadwal Pickup: ${fd.get('pickup_schedule') || '-'}`);
                    senderLines.push(`Catatan Pickup: ${fd.get('pickup_note') || '-'}`);
                } else if (serviceType === 'b2c') {
                    senderLines.push(`Nama Pengirim: ${fd.get('sender_name') || '-'}`);
                    senderLines.push(`Telepon: ${fd.get('sender_phone_b2c') || '-'}`);
                    senderLines.push(`Email: ${fd.get('sender_email_b2c') || '-'}`);
                    senderLines.push(`Kantor: ${fd.get('office_id') || '-'}`);
                }
                reviewSender.textContent = toMultiline(senderLines);

                const receiverLines = [
                    `Nama: ${fd.get('receiver_name') || '-'}`,
                    `Telepon: ${fd.get('receiver_phone') || '-'}`,
                    `Alamat: ${fd.get('receiver_address') || '-'}`,
                    `Catatan: ${fd.get('receiver_note') || '-'}`
                ];
                reviewReceiver.textContent = toMultiline(receiverLines);

                const dims = [fd.get('item_length_cm'), fd.get('item_width_cm'), fd.get('item_height_cm')]
                    .filter((v) => v !== null && String(v).trim() !== '')
                    .join(' x ');
                const itemLines = [
                    `Deskripsi: ${fd.get('item_description') || '-'}`,
                    `Berat (kg): ${fd.get('item_weight_kg') || '-'}`,
                    `Dimensi (cm): ${dims || '-'}`,
                    `Armada: ${fd.get('fleet_type') || '-'}`,
                    `Fragile: ${fd.get('item_fragile') ? 'Ya' : 'Tidak'}`,
                    `Catatan: ${fd.get('item_note') || '-'}`
                ];
                reviewItem.textContent = toMultiline(itemLines);
            }

            function openTermsModal() {
                termsModal.classList.remove('hidden');
                termsModal.classList.add('flex');
            }

            function closeTermsModal() {
                termsModal.classList.add('hidden');
                termsModal.classList.remove('flex');
            }

            chooseB2B.addEventListener('click', () => {
                applyServiceType('b2b');
                setStep(2);
            });
            chooseB2C.addEventListener('click', () => {
                applyServiceType('b2c');
                setStep(2);
            });

            backToStep1.addEventListener('click', () => setStep(1));
            backToStep2.addEventListener('click', () => setStep(2));

            goToReview.addEventListener('click', () => {
                if (!orderForm.reportValidity()) return;
                formatReview();
                setStep(3);
            });

            submitOrderBtn.addEventListener('click', () => {
                if (!termsCheck.checked) {
                    openTermsModal();
                    return;
                }
                orderForm.submit();
            });

            editService.addEventListener('click', () => setStep(1));
            editStep2Sender.addEventListener('click', () => setStep(2));
            editStep2Receiver.addEventListener('click', () => setStep(2));
            editStep2Item.addEventListener('click', () => setStep(2));

            openTerms.addEventListener('click', openTermsModal);
            closeTerms.addEventListener('click', closeTermsModal);
            agreeTerms.addEventListener('click', () => {
                termsCheck.checked = true;
                closeTermsModal();
            });
            termsModal.addEventListener('click', (e) => {
                if (e.target === termsModal) closeTermsModal();
            });

            officeSelect.addEventListener('change', (e) => {
                const id = e.target.value;
                const office = offices[id];
                if (!office) {
                    officeInfo.classList.add('hidden');
                    return;
                }
                officeName.textContent = office.name;
                officeAddress.textContent = office.address;
                officeHours.textContent = office.hours;
                officeContact.textContent = office.contact;
                officeInfo.classList.remove('hidden');
            });

            setStep(1);
        })();
    </script>
@endsection

