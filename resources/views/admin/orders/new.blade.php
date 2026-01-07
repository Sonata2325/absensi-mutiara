@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pesanan Baru</h1>
                    <p class="mt-2 text-gray-600">Daftar pesanan dengan status menunggu konfirmasi / menunggu drop barang.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.grouping') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Scan & Grouping</a>
                    <a href="{{ route('admin.shipments.active') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Shipment Aktif</a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="text-left font-semibold px-5 py-4">Nomor Resi</th>
                                <th class="text-left font-semibold px-5 py-4">Tanggal</th>
                                <th class="text-left font-semibold px-5 py-4">Jenis</th>
                                <th class="text-left font-semibold px-5 py-4">Pengirim</th>
                                <th class="text-left font-semibold px-5 py-4">Pickup/Drop</th>
                                <th class="text-left font-semibold px-5 py-4">Penerima</th>
                                <th class="text-left font-semibold px-5 py-4">Tujuan</th>
                                <th class="text-left font-semibold px-5 py-4">Berat</th>
                                <th class="text-left font-semibold px-5 py-4">Status</th>
                                <th class="text-right font-semibold px-5 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $order->nomor_resi }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $order->tanggal_order?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700 uppercase">{{ $order->jenis_layanan }}</td>
                                    <td class="px-5 py-4 text-gray-700 max-w-xs">{{ $order->pengirim_nama ?: '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700 max-w-xs">
                                        @if($order->jenis_layanan === 'b2b')
                                            {{ $order->pengirim_alamat_pickup ?: '-' }}
                                        @else
                                            {{ $order->pengirim_office_id ?: '-' }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-gray-700 max-w-xs">{{ $order->penerima_nama }}</td>
                                    <td class="px-5 py-4 text-gray-700 max-w-xs">{{ $order->penerima_alamat }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ rtrim(rtrim((string) $order->berat_kg, '0'), '.') }} kg</td>
                                    <td class="px-5 py-4">
                                        @php
                                            $status = (string) $order->status;
                                            $badge = match ($status) {
                                                'menunggu_konfirmasi' => ['Menunggu Konfirmasi', 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                                                'menunggu_drop_barang' => ['Menunggu Drop Barang', 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                                                default => [$status, 'bg-slate-100 text-slate-800 border-slate-200'],
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold {{ $badge[1] }}">{{ $badge[0] }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 rounded-lg bg-gray-900 hover:bg-black text-white font-semibold transition">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-5 py-10 text-center text-gray-600">
                                        Tidak ada pesanan baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

