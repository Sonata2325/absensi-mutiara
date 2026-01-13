@extends('layouts.app')

@section('content')
<section class="py-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Lacak Paket</h1>
                <p class="text-gray-600 mt-2">Pantau status pengiriman barang Anda secara real-time</p>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8 mb-8">
                <form action="{{ route('tracking') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" 
                           name="resi" 
                           value="{{ request('resi') }}"
                           placeholder="Masukkan Nomor Resi (Contoh: MJE12345678)" 
                           class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           required>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-8 py-3 rounded-lg transition">
                        Lacak Paket
                    </button>
                </form>
            </div>

            @if(request('resi'))
                @if(!$order)
                    <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6">
                        <div class="font-bold text-gray-900">Resi tidak ditemukan</div>
                        <div class="text-gray-600 mt-2">Pastikan nomor resi benar atau coba lagi beberapa saat.</div>
                    </div>
                @else
                    @php
                        $status = (string) $order->status;
                        $truckPlate = $order->truck?->plat_nomor;
                        $badge = match ($status) {
                            'menunggu_konfirmasi' => ['Menunggu Konfirmasi', 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                            'menunggu_drop_barang' => ['Menunggu Drop Barang', 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                            'dikonfirmasi_menunggu_pickup' => ['Dikonfirmasi - Menunggu Pickup', 'bg-blue-100 text-blue-800 border-blue-200'],
                            'dimuat_di_truck' => ['Barang Dimuat di Truck ' . ($truckPlate ?: '-'), 'bg-blue-100 text-blue-800 border-blue-200'],
                            'dalam_perjalanan' => ['Dalam Perjalanan - Truck ' . ($truckPlate ?: '-'), 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                            'tiba_di_tujuan' => ['Tiba di Tujuan', 'bg-blue-100 text-blue-800 border-blue-200'],
                            'selesai' => ['Selesai', 'bg-slate-200 text-slate-800 border-slate-300'],
                            'dibatalkan' => ['Dibatalkan', 'bg-red-100 text-red-800 border-red-200'],
                            default => ['Diproses', 'bg-slate-100 text-slate-800 border-slate-200'],
                        };
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 animate-fade-in-up">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b pb-5">
                            <div>
                                <div class="text-sm text-gray-500">Nomor Resi</div>
                                <div class="text-2xl font-extrabold text-gray-900 tracking-wider">{{ $order->nomor_resi }}</div>
                            </div>
                            <div class="inline-flex items-center px-3 py-1.5 rounded-full border font-semibold {{ $badge[1] }}">
                                {{ $badge[0] }}
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Detail Pesanan</div>
                                <div class="space-y-3 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Tanggal Order</div>
                                        <div class="font-semibold text-right">{{ $order->tanggal_order?->format('d M Y, H:i') ?? '-' }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Jenis Layanan</div>
                                        <div class="font-semibold text-right">{{ strtoupper((string) $order->jenis_layanan) }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Armada Diminta</div>
                                        <div class="font-semibold text-right">{{ $order->jenis_armada_diminta ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Informasi Barang</div>
                                <div class="space-y-3 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Deskripsi</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->deskripsi_barang }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Berat</div>
                                        <div class="font-semibold text-right">{{ rtrim(rtrim((string) $order->berat_kg, '0'), '.') }} kg</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Catatan</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->catatan_barang ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-white border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Informasi Pengirim</div>
                                <div class="space-y-2 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Nama/Perusahaan</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->pengirim_nama ?: '-' }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Kontak</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->pengirim_kontak_person ?: '-' }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Telepon</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->pengirim_telepon ?: '-' }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Email</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->pengirim_email ?: '-' }}</div>
                                    </div>
                                    @if($order->jenis_layanan === 'b2b')
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="text-gray-500">Alamat Pickup</div>
                                            <div class="font-semibold text-right max-w-xs whitespace-pre-line">{{ $order->pengirim_alamat_pickup ?: '-' }}</div>
                                        </div>
                                    @else
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="text-gray-500">Kantor Drop</div>
                                            <div class="font-semibold text-right max-w-xs">{{ $order->pengirim_office_id ?: '-' }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Informasi Penerima</div>
                                <div class="space-y-2 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Nama</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->penerima_nama }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Telepon</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->penerima_telepon }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Alamat Tujuan</div>
                                        <div class="font-semibold text-right max-w-xs whitespace-pre-line">{{ $order->penerima_alamat }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Catatan</div>
                                        <div class="font-semibold text-right max-w-xs">{{ $order->penerima_catatan ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Informasi Pengiriman</div>
                                <div class="space-y-3 text-gray-800">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Driver</div>
                                        <div class="font-semibold text-right">{{ $order->driver?->nama ?: '-' }}</div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Truck</div>
                                        <div class="font-semibold text-right">
                                            @if($order->truck)
                                                {{ $order->truck->plat_nomor }} - {{ $order->truck->jenis_armada }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-gray-500">Kontak Driver</div>
                                        <div class="font-semibold text-right">
                                            @if($order->driver?->telepon)
                                                <a class="text-primary hover:underline" href="tel:{{ preg_replace('/\s+/', '', $order->driver->telepon) }}">{{ $order->driver->telepon }}</a>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    @if($otherOrdersCount !== null)
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="text-gray-500">Pesanan di Truck</div>
                                            <div class="font-semibold text-right">
                                                Truck ini membawa {{ $otherOrdersCount + 1 }} pesanan termasuk Anda
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white border rounded-2xl p-6">
                                <div class="font-bold text-gray-900 mb-4">Timeline Status</div>
                                @if($history->isEmpty())
                                    <div class="text-gray-600">Belum ada riwayat status.</div>
                                @else
                                    <div class="space-y-3">
                                        @foreach($history as $item)
                                            <details class="border rounded-xl p-4 bg-gray-50">
                                                <summary class="cursor-pointer flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                                    <div class="font-semibold text-gray-900">{{ str_replace('_', ' ', $item->status_baru) }}</div>
                                                    <div class="text-sm text-gray-600">{{ $item->created_at?->format('d M Y, H:i') }}</div>
                                                </summary>
                                                <div class="mt-3 text-gray-700 space-y-2">
                                                    @if($item->admin_nama)
                                                        <div>Admin: <span class="font-semibold">{{ $item->admin_nama }}</span></div>
                                                    @endif
                                                    @if($item->keterangan)
                                                        <div class="whitespace-pre-line">{{ $item->keterangan }}</div>
                                                    @endif
                                                </div>
                                            </details>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
