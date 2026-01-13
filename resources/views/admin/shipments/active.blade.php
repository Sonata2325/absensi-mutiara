@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Shipment Aktif</h1>
                    <p class="mt-2 text-gray-600">Daftar truck yang sedang dalam perjalanan.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.orders.new') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Pesanan Baru</a>
                    <a href="{{ route('admin.grouping') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Scan & Grouping</a>
                    <a href="{{ route('admin.shipments.history') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">History</a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($sessions as $session)
                    @php
                        $orders = $session->orders ?? collect();
                        $totalWeight = (float) $orders->sum('berat_kg');
                    @endphp
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="text-lg font-bold text-gray-900">
                                        Truck {{ $session->truck?->plat_nomor }} - {{ $session->truck?->jenis_armada }}
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold {{ $session->status === 'tiba_di_tujuan' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-emerald-100 text-emerald-800 border-emerald-200' }}">
                                        {{ $session->status === 'tiba_di_tujuan' ? 'Tiba di Tujuan' : 'Dalam Perjalanan' }}
                                    </span>
                                </div>
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-800">
                                    <div class="bg-gray-50 border rounded-xl p-4">
                                        <div class="text-sm text-gray-500">Driver</div>
                                        <div class="font-semibold">{{ $session->driver?->nama ?: '-' }}</div>
                                        <div class="text-sm text-gray-600 mt-1">{{ $session->driver?->telepon ?: '-' }}</div>
                                    </div>
                                    <div class="bg-gray-50 border rounded-xl p-4">
                                        <div class="text-sm text-gray-500">Berangkat</div>
                                        <div class="font-semibold">{{ $session->waktu_berangkat?->format('d M Y, H:i') ?: '-' }}</div>
                                        <div class="text-sm text-gray-600 mt-1">Admin: {{ $session->admin_berangkatkan_nama ?: '-' }}</div>
                                    </div>
                                    <div class="bg-gray-50 border rounded-xl p-4">
                                        <div class="text-sm text-gray-500">Ringkasan</div>
                                        <div class="font-semibold">{{ $orders->count() }} pesanan</div>
                                        <div class="text-sm text-gray-600 mt-1">{{ rtrim(rtrim((string) $totalWeight, '0'), '.') }} kg</div>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <div class="font-semibold text-gray-900">Daftar Pesanan</div>
                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($orders as $o)
                                            <div class="border rounded-xl p-4 bg-gray-50">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div class="font-bold text-gray-900">{{ $o->nomor_resi }}</div>
                                                    <div class="text-sm text-gray-600">{{ rtrim(rtrim((string) $o->berat_kg, '0'), '.') }} kg</div>
                                                </div>
                                                <div class="mt-1 flex items-center gap-2">
                                                    <span class="text-xs px-2 py-0.5 rounded {{ $o->status === 'tiba_di_tujuan' ? 'bg-blue-100 text-blue-800' : ($o->status === 'selesai' ? 'bg-gray-100 text-gray-800' : 'bg-emerald-100 text-emerald-800') }}">
                                                        {{ str_replace('_', ' ', ucfirst($o->status)) }}
                                                    </span>
                                                    <span class="text-sm text-gray-700 truncate max-w-[200px]">{{ $o->penerima_alamat }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="w-full lg:w-80 space-y-6">
                                @if($session->status !== 'tiba_di_tujuan')
                                <div class="bg-white border rounded-2xl p-5 shadow-sm">
                                    <div class="font-bold text-gray-900">Update Kedatangan</div>
                                    <form method="POST" action="{{ route('admin.shipments.arrive', $session) }}" class="mt-4 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                            <input name="admin_nama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan</label>
                                            <textarea name="catatan" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                        </div>
                                        <details class="border rounded-xl p-4 bg-gray-50">
                                            <summary class="cursor-pointer font-semibold text-gray-900 text-sm">Pilih Barang (Opsional)</summary>
                                            <div class="mt-3 space-y-2 max-h-40 overflow-y-auto">
                                                @foreach($orders as $o)
                                                    @if($o->status === 'dalam_perjalanan')
                                                    <label class="flex items-center gap-2 text-gray-700">
                                                        <input type="checkbox" name="order_ids[]" value="{{ $o->id }}" class="w-4 h-4 text-primary border-gray-300 rounded">
                                                        <span class="text-sm">{{ $o->nomor_resi }}</span>
                                                    </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </details>
                                        <button class="w-full px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold transition">
                                            Tandai Tiba
                                        </button>
                                    </form>
                                </div>
                                @endif

                                <div class="bg-gray-50 border rounded-2xl p-5">
                                    <div class="font-bold text-gray-900">Selesaikan Pengiriman</div>
                                    <form method="POST" action="{{ route('admin.shipments.finish', $session) }}" class="mt-4 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                            <input name="admin_nama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        </div>
                                        <details class="border rounded-xl p-4 bg-white">
                                            <summary class="cursor-pointer font-semibold text-gray-900">Selesaikan per Barang</summary>
                                            <div class="mt-3 space-y-2">
                                                @foreach($orders as $o)
                                                    @if(in_array($o->status, ['dalam_perjalanan', 'tiba_di_tujuan']))
                                                    <label class="flex items-center gap-2 text-gray-700">
                                                        <input type="checkbox" name="order_ids[]" value="{{ $o->id }}" class="w-4 h-4 text-primary border-gray-300 rounded">
                                                        <span class="font-semibold">{{ $o->nomor_resi }}</span>
                                                    </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </details>
                                        <button class="w-full px-6 py-3 rounded-lg bg-gray-900 hover:bg-black text-white font-bold transition">
                                            Tandai Selesai
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border rounded-2xl p-10 text-center text-gray-600 shadow-sm">
                        Tidak ada shipment aktif.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

