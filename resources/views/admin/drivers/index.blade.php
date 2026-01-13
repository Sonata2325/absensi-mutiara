@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Driver</h1>
                    <p class="mt-2 text-gray-600">Kelola data supir/driver logistik.</p>
                </div>
                <div>
                    <a href="{{ route('admin.drivers.create') }}" class="px-5 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Tambah Driver
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
                                <th class="text-left font-semibold px-5 py-4">Nama</th>
                                <th class="text-left font-semibold px-5 py-4">Nomor Telepon</th>
                                <th class="text-left font-semibold px-5 py-4">Nomor SIM</th>
                                <th class="text-left font-semibold px-5 py-4">Truck Saat Ini</th>
                                <th class="text-left font-semibold px-5 py-4">Status</th>
                                <th class="text-right font-semibold px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($drivers as $driver)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">{{ $driver->nama }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $driver->telepon }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">{{ $driver->nomor_sim }}</td>
                                    <td class="px-5 py-4 text-gray-700 whitespace-nowrap">
                                        @if($driver->truck)
                                            <span class="text-blue-600 font-medium">{{ $driver->truck->plat_nomor }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $badgeClass = match ($driver->status) {
                                                'aktif' => 'bg-green-100 text-green-800 border-green-200',
                                                'sedang_bertugas' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'nonaktif' => 'bg-red-100 text-red-800 border-red-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-xs font-bold {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-right whitespace-nowrap flex justify-end gap-2">
                                        <a href="{{ route('admin.drivers.edit', $driver) }}" class="text-gray-500 hover:text-blue-600 font-medium">Edit</a>
                                        <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-600 font-medium ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-600">
                                        Belum ada data driver.
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
