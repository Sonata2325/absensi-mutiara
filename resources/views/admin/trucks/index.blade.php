@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Truck</h1>
                    <p class="mt-2 text-gray-600">Kelola data armada truck (CDE, CDD, Fuso, Tronton).</p>
                </div>
                <div>
                    <a href="{{ route('admin.trucks.create') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Truck
                    </a>
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
                                <th class="text-left font-semibold px-5 py-4">Plat Nomor</th>
                                <th class="text-left font-semibold px-5 py-4">Jenis Armada</th>
                                <th class="text-left font-semibold px-5 py-4">Kapasitas (Kg)</th>
                                <th class="text-left font-semibold px-5 py-4">Driver Saat Ini</th>
                                <th class="text-left font-semibold px-5 py-4">Status</th>
                                <th class="text-right font-semibold px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($trucks as $truck)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $truck->plat_nomor }}</td>
                                    <td class="px-5 py-4 text-gray-700 uppercase">{{ str_replace('_', ' ', $truck->jenis_armada) }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ number_format($truck->kapasitas_kg, 0, ',', '.') }} kg</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">
                                        @if($truck->driver)
                                            <span class="text-blue-600 font-medium">{{ $truck->driver->nama }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $badgeClass = match ($truck->status) {
                                                'tersedia' => 'bg-green-100 text-green-800 border-green-200',
                                                'dalam_perjalanan' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'perbaikan' => 'bg-red-100 text-red-800 border-red-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $truck->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap flex justify-end gap-2">
                                        <a href="{{ route('admin.trucks.edit', $truck) }}" class="text-gray-500 hover:text-blue-600 font-medium">Edit</a>
                                        <form action="{{ route('admin.trucks.destroy', $truck) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus truck ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-600 font-medium ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-600">
                                        Belum ada data truck.
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
