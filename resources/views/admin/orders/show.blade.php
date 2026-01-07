@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <div class="text-sm text-gray-500">Detail Pesanan</div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $order->nomor_resi }}</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.orders.new') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Kembali</a>
                    <a href="{{ route('admin.grouping') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Scan & Grouping</a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div class="font-bold text-gray-900">Ringkasan</div>
                            <div class="text-sm text-gray-600">{{ $order->tanggal_order?->format('Y-m-d H:i') ?? '-' }}</div>
                        </div>

                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800">
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="text-sm text-gray-500">Jenis Layanan</div>
                                <div class="font-bold uppercase">{{ $order->jenis_layanan }}</div>
                            </div>
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="text-sm text-gray-500">Status</div>
                                <div class="font-bold">{{ str_replace('_', ' ', $order->status) }}</div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="font-semibold text-gray-900">Pengirim</div>
                                <div class="mt-2 text-gray-700 space-y-1">
                                    <div>{{ $order->pengirim_nama ?: '-' }}</div>
                                    <div>{{ $order->pengirim_kontak_person ?: '-' }}</div>
                                    <div>{{ $order->pengirim_telepon ?: '-' }}</div>
                                    <div>{{ $order->pengirim_email ?: '-' }}</div>
                                    @if($order->jenis_layanan === 'b2b')
                                        <div class="whitespace-pre-line">{{ $order->pengirim_alamat_pickup ?: '-' }}</div>
                                    @else
                                        <div>Kantor: {{ $order->pengirim_office_id ?: '-' }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="font-semibold text-gray-900">Penerima</div>
                                <div class="mt-2 text-gray-700 space-y-1">
                                    <div>{{ $order->penerima_nama }}</div>
                                    <div>{{ $order->penerima_telepon }}</div>
                                    <div class="whitespace-pre-line">{{ $order->penerima_alamat }}</div>
                                    <div>{{ $order->penerima_catatan ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900">Informasi Barang</div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="text-sm text-gray-500">Deskripsi</div>
                                <div class="mt-1 font-semibold whitespace-pre-line">{{ $order->deskripsi_barang }}</div>
                            </div>
                            <div class="bg-gray-50 border rounded-xl p-4">
                                <div class="text-sm text-gray-500">Berat</div>
                                <div class="mt-1 font-bold">{{ rtrim(rtrim((string) $order->berat_kg, '0'), '.') }} kg</div>
                                <div class="mt-3 text-sm text-gray-500">Armada diminta</div>
                                <div class="font-semibold">{{ $order->jenis_armada_diminta ?: '-' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($order->jenis_layanan === 'b2b' && $order->status === 'menunggu_konfirmasi')
                        <div class="bg-white border rounded-2xl p-6 shadow-sm">
                            <div class="font-bold text-gray-900">Konfirmasi Pesanan (B2B)</div>
                            <form method="POST" action="{{ route('admin.orders.confirm', $order) }}" class="mt-4 space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                        <input name="admin_nama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Contoh: Budi Santoso">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jadwal Pickup</label>
                                        <input name="pickup_schedule" type="datetime-local" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Driver untuk Pickup</label>
                                    <select name="driver_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">Pilih driver</option>
                                        @foreach($drivers as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }} ({{ $d->telepon }}) - {{ $d->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan untuk Customer</label>
                                    <textarea name="catatan" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Contoh: Pickup dijadwalkan besok pagi"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button class="px-6 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Konfirmasi</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($order->status !== 'dibatalkan' && $order->status !== 'selesai')
                        <div class="bg-white border rounded-2xl p-6 shadow-sm">
                            <div class="font-bold text-gray-900">Batalkan Pesanan</div>
                            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}" class="mt-4 space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                        <input name="admin_nama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan</label>
                                        <select name="alasan" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                            <option value="">Pilih alasan</option>
                                            <option value="Data tidak valid">Data tidak valid</option>
                                            <option value="Barang tidak sesuai">Barang tidak sesuai</option>
                                            <option value="Permintaan customer">Permintaan customer</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan</label>
                                    <textarea name="catatan" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button class="px-6 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition">Batalkan</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900">QR Code</div>
                        <div class="mt-4 bg-gray-50 border rounded-xl p-4 flex flex-col items-center gap-4">
                            <img id="qrImage" alt="QR Code Resi" class="w-56 h-56 object-contain">
                            <div class="flex gap-3">
                                <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition" id="downloadQrBtn">Download QR</button>
                                <button type="button" class="px-4 py-2 rounded-lg bg-gray-900 hover:bg-black text-white font-semibold transition" id="printQrBtn">Print QR</button>
                            </div>
                            <div class="text-sm text-gray-600 text-center">Print QR ini dan tempel pada barang.</div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900">Shortcut</div>
                        <div class="mt-4 flex flex-col gap-3">
                            <a href="{{ route('admin.grouping', ['truck_id' => $order->truck_id]) }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition text-center">Buka Grouping</a>
                            <a href="{{ route('tracking', ['resi' => $order->nomor_resi]) }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition text-center">Lihat Tracking Customer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        const resi = @json($order->nomor_resi);
        const qrPayload = @json($qrPayload ?? '');
        const qrImage = document.getElementById('qrImage');
        const downloadQrBtn = document.getElementById('downloadQrBtn');
        const printQrBtn = document.getElementById('printQrBtn');

        function qrUrlFor(payload, size) {
            const qrSize = size || 320;
            return `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(payload || '')}`;
        }

        if (resi) {
            qrImage.src = qrUrlFor(qrPayload || '');
        }

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

        printQrBtn.addEventListener('click', () => {
            const printWindow = window.open('', '_blank');
            if (!printWindow) return;
            const html = `
                <html>
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Print QR - ${resi || ''}</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 24px; }
                        .wrap { display: flex; flex-direction: column; align-items: center; gap: 16px; }
                        .resi { font-size: 18px; font-weight: 700; letter-spacing: 1px; }
                        img { width: 360px; height: 360px; object-fit: contain; }
                    </style>
                </head>
                <body>
                    <div class="wrap">
                        <div class="resi">${resi || ''}</div>
                        <img src="${qrUrlFor(qrPayload || '', 720)}" alt="QR">
                    </div>
                    <script>
                        window.onload = function () { window.print(); setTimeout(() => window.close(), 300); };
                    <\/script>
                </body>
                </html>
            `;
            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
        });
    })();
</script>
@endsection

