@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">History Shipment</h1>
                    <p class="mt-2 text-gray-600">Riwayat pengiriman yang sudah selesai atau dibatalkan.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.shipments.active') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Shipment Aktif</a>
                    <a href="{{ route('admin.grouping') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Scan & Grouping</a>
                </div>
            </div>

            <div class="bg-white border rounded-2xl p-6 shadow-sm mb-6">
                <form method="GET" action="{{ route('admin.shipments.history') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dari</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sampai</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Truck</label>
                        <select name="truck_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Semua</option>
                            @foreach($trucks as $t)
                                <option value="{{ $t->id }}" @selected((string) request('truck_id') === (string) $t->id)>{{ $t->plat_nomor }} - {{ $t->jenis_armada }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Driver</label>
                        <select name="driver_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Semua</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}" @selected((string) request('driver_id') === (string) $d->id)>{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Semua</option>
                            <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                            <option value="dibatalkan" @selected(request('status') === 'dibatalkan')>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="md:col-span-5 flex justify-end gap-3">
                        <a href="{{ route('admin.shipments.history') }}" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Reset</a>
                        <button class="px-6 py-3 rounded-lg bg-gray-900 hover:bg-black text-white font-bold transition">Filter</button>
                    </div>
                </form>
            </div>

            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="text-left font-semibold px-5 py-4">Truck</th>
                                <th class="text-left font-semibold px-5 py-4">Driver</th>
                                <th class="text-left font-semibold px-5 py-4">Berangkat</th>
                                <th class="text-left font-semibold px-5 py-4">Selesai</th>
                                <th class="text-left font-semibold px-5 py-4">Total Pesanan</th>
                                <th class="text-left font-semibold px-5 py-4">Total Berat</th>
                                <th class="text-left font-semibold px-5 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($sessions as $s)
                                @php
                                    $orders = $s->orders ?? collect();
                                    $totalWeight = (float) $orders->sum('berat_kg');
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold text-gray-900 whitespace-nowrap">{{ $s->truck?->plat_nomor }} - {{ $s->truck?->jenis_armada }}</td>
                                    <td class="px-5 py-4 text-gray-700">{{ $s->driver?->nama }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $s->waktu_berangkat?->format('Y-m-d H:i') ?: '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $s->waktu_selesai?->format('Y-m-d H:i') ?: '-' }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $orders->count() }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ rtrim(rtrim((string) $totalWeight, '0'), '.') }} kg</td>
                                    <td class="px-5 py-4">
                                        @php
                                            $badge = $s->status === 'selesai'
                                                ? ['Selesai', 'bg-slate-200 text-slate-800 border-slate-300']
                                                : ['Dibatalkan', 'bg-red-100 text-red-800 border-red-200'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold {{ $badge[1] }}">{{ $badge[0] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-10 text-center text-gray-600">
                                        Tidak ada data history.
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

