@extends('layouts.app')

@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white border rounded-2xl p-6 md:p-10 shadow-sm">
                    <div class="flex flex-col items-center text-center gap-4">
                        <div class="w-20 h-20 rounded-full bg-green-100 text-green-700 flex items-center justify-center">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl md:text-4xl font-bold text-gray-900">Pesanan Berhasil Dibuat!</h1>
                        <p class="text-gray-600 max-w-2xl">Terima kasih atas kepercayaan Anda menggunakan jasa PT Mutiara Jaya Express</p>
                    </div>

                    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-gray-50 border rounded-2xl p-6">
                            <div class="text-sm text-gray-500">Nomor Resi Anda:</div>
                            <div class="mt-2 flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-wider" id="resiText">{{ $resi ?: '-' }}</div>
                                <button type="button" class="px-4 py-2 rounded-lg bg-primary hover:bg-blue-800 text-white font-semibold transition" id="copyResiBtn">Copy Nomor Resi</button>
                            </div>
                            <div class="mt-6">
                                <div class="text-sm font-semibold text-gray-800 mb-2">QR Code</div>
                                <div class="bg-white border rounded-xl p-4 flex flex-col items-center gap-4">
                                    <img
                                        id="qrImage"
                                        alt="QR Code Resi"
                                        class="w-56 h-56 object-contain"
                                    >
                                    <div class="flex gap-3">
                                        <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition" id="downloadQrBtn">Download QR Code</button>
                                    </div>
                                    <div class="text-sm text-gray-600 text-center">Simpan QR Code ini dan tempel pada barang yang akan dikirim</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 border rounded-2xl p-6 space-y-6">
                            <div>
                                <div class="font-bold text-gray-900">Detail Pesanan</div>
                                <div class="mt-4 grid grid-cols-1 gap-3 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Tanggal order</div>
                                        <div class="font-semibold text-right">{{ $order->tanggal_order?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Jenis layanan</div>
                                        <div class="font-semibold text-right">{{ strtoupper((string) $order->jenis_layanan) }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Alamat pengirim → penerima</div>
                                        <div class="font-semibold text-right max-w-xs">
                                            {{ $order->jenis_layanan === 'b2b' ? (string) ($order->pengirim_alamat_pickup ?: '-') : (string) ($order->pengirim_office_id ?: '-') }}
                                            →
                                            {{ (string) ($order->penerima_alamat ?: '-') }}
                                        </div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Estimasi waktu proses</div>
                                        <div class="font-semibold text-right">Konfirmasi admin 1x24 jam</div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-6">
                                <div class="font-bold text-gray-900">Informasi Selanjutnya</div>

                                @if ($order->jenis_layanan === 'b2c')
                                    <div class="mt-4 space-y-2 text-gray-700">
                                        <div>Silakan drop barang Anda ke kantor MJE:</div>
                                        @if ($office)
                                            <div class="bg-white border rounded-xl p-4">
                                                <div class="font-semibold text-gray-900">{{ $office['name'] }}</div>
                                                <div class="text-gray-700 mt-1">{{ $office['address'] }}</div>
                                                <div class="text-sm text-gray-600 mt-2">Jam operasional: {{ $office['hours'] }}</div>
                                            </div>
                                        @else
                                            <div class="bg-white border rounded-xl p-4">
                                                <div class="font-semibold text-gray-900">Kantor yang dipilih</div>
                                                <div class="text-gray-700 mt-1">{{ (string) data_get($order, 'sender.office_id', '-') }}</div>
                                            </div>
                                        @endif
                                        <div>Bawa QR Code ini saat drop barang</div>
                                        <div>Tempelkan QR Code pada barang</div>
                                    </div>
                                @else
                                    <div class="mt-4 space-y-2 text-gray-700">
                                        <div>Admin kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi ketersediaan driver dan jadwal pickup</div>
                                        <div>Anda akan menerima email konfirmasi di: <span class="font-semibold">{{ (string) ($order->pengirim_email ?: '-') }}</span></div>
                                        <div>Tempelkan QR Code pada barang sebelum pickup</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col md:flex-row gap-3 justify-center">
                        <a href="{{ route('home', ['resi' => $resi]) }}#tracking" class="px-6 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition text-center">Lacak Pesanan Saya</a>
                        <a href="{{ route('order') }}" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition text-center">Buat Pesanan Baru</a>
                        <a href="{{ route('home') }}" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition text-center">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const resi = @json($resi);
            const qrPayload = @json($qrPayload ?? '');
            const qrImage = document.getElementById('qrImage');
            const copyResiBtn = document.getElementById('copyResiBtn');
            const downloadQrBtn = document.getElementById('downloadQrBtn');

            function qrUrlFor(payload, size) {
                const qrSize = size || 320;
                return `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(payload || '')}`;
            }

            if (resi) {
                qrImage.src = qrUrlFor(qrPayload || '');
            }

            copyResiBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(resi || '');
                } catch (e) {
                    const textarea = document.createElement('textarea');
                    textarea.value = resi || '';
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                }
            });

            downloadQrBtn.addEventListener('click', async () => {
                const url = qrUrlFor(qrPayload || '', 1024);
                const response = await fetch(url);
                const blob = await response.blob();
                const objectUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = objectUrl;
                a.download = `QR-${resi || 'resi'}.png`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(objectUrl);
            });
        })();
    </script>
@endsection
