@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Monitor Absensi Real-time</h1>
        <p class="text-gray-500 mt-1 text-sm">Pantau status kehadiran hari ini</p>
    </div>
</div>

<div class="bg-white border border-gray-100 rounded-2xl p-6 mb-6 text-sm text-gray-700 shadow-sm">
    <div class="font-semibold mb-2 text-gray-900 text-base">Informasi Lokasi Kantor</div>
    <div class="flex flex-wrap items-center gap-4 text-gray-600">
        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200/50">
            <span class="font-medium text-xs uppercase tracking-wide text-gray-500">Lat</span>
            <span>{{ $office['lat'] ?: '-' }}</span>
        </div>
        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200/50">
            <span class="font-medium text-xs uppercase tracking-wide text-gray-500">Lng</span>
            <span>{{ $office['lng'] ?: '-' }}</span>
        </div>
        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200/50">
            <span class="font-medium text-xs uppercase tracking-wide text-gray-500">Radius</span>
            <span>{{ $office['radius'] }}m</span>
        </div>
        
        <div class="flex items-center gap-3 ml-2">
            @if($office['lat'] !== '' && $office['lng'] !== '')
                <a class="text-blue-600 hover:text-blue-700 hover:underline font-medium text-sm flex items-center gap-1" href="https://www.google.com/maps?q={{ $office['lat'] }},{{ $office['lng'] }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Buka Maps
                </a>
            @endif
            <a class="text-gray-600 hover:text-gray-900 hover:underline font-medium text-sm flex items-center gap-1" href="{{ route('admin.settings.edit') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Ubah Lokasi
            </a>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Nama</th>
                    <th class="px-6 py-4 font-medium">Posisi</th>
                    <th class="px-6 py-4 font-medium">Shift</th>
                    <th class="px-6 py-4 font-medium">Status Hari Ini</th>
                    <th class="px-6 py-4 font-medium">Overtime</th>
                    <th class="px-6 py-4 font-medium">Deskripsi</th>
                    <th class="px-6 py-4 font-medium">Jam Masuk</th>
                    <th class="px-6 py-4 font-medium">Lokasi/Foto Masuk</th>
                    <th class="px-6 py-4 font-medium">Jam Keluar</th>
                    <th class="px-6 py-4 font-medium">Lokasi/Foto Keluar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($employees as $e)
                    @php
                        $att = $attendanceToday->get($e->id);
                        $lv = $leaveToday->get($e->id);
                        $status = $lv ? 'izin' : ($att?->status ?? 'belum absen');
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $e->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $e->position?->nama_posisi }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $e->shift?->nama_shift }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $status === 'hadir' ? 'bg-green-50 text-green-700 ring-1 ring-green-200/50' : '' }}
                                {{ $status === 'terlambat' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200/50' : '' }}
                                {{ $status === 'izin' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/50' : '' }}
                                {{ $status === 'belum absen' ? 'bg-gray-100 text-gray-700 ring-1 ring-gray-200/50' : '' }}
                            ">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if(($att->status ?? '') === 'overtime')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-200/50">
                                    Ya
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $att->keterangan ?? '' }}">
                            {{ $att->keterangan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-900">{{ $att?->jam_masuk ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($att && $att->jam_masuk)
                                <div class="flex flex-col gap-1 text-xs">
                                    @if($att->foto_masuk)
                                        <a href="{{ route('admin.file', ['path' => $att->foto_masuk]) }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-700 font-medium">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-400 italic">No Foto</span>
                                    @endif
                                    
                                    @if($att->lokasi_masuk_lat)
                                        <a href="https://www.google.com/maps?q={{ $att->lokasi_masuk_lat }},{{ $att->lokasi_masuk_lng }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-700 font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            Maps
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-900">{{ $att?->jam_keluar ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($att && $att->jam_keluar)
                                <div class="flex flex-col gap-1 text-xs">
                                    @if($att->foto_keluar)
                                        <a href="{{ route('admin.file', ['path' => $att->foto_keluar]) }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-700 font-medium">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-400 italic">No Foto</span>
                                    @endif
                                    
                                    @if($att->lokasi_keluar_lat)
                                        <a href="https://www.google.com/maps?q={{ $att->lokasi_keluar_lat }},{{ $att->lokasi_keluar_lng }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-700 font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            Maps
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
