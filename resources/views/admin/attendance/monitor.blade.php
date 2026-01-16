@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Monitor Absensi Real-time</h1>

<div class="bg-white border rounded-2xl p-4 mb-6 text-sm text-gray-700">
    <div class="font-bold mb-1">Office</div>
    <div>
        Lat: {{ $office['lat'] ?: '-' }}, Lng: {{ $office['lng'] ?: '-' }}, Radius: {{ $office['radius'] }}m
        @if($office['lat'] !== '' && $office['lng'] !== '')
            <a class="text-blue-600 hover:underline ml-2" href="https://www.google.com/maps?q={{ $office['lat'] }},{{ $office['lng'] }}" target="_blank">Maps</a>
        @endif
        <a class="text-blue-600 hover:underline ml-2" href="{{ route('admin.settings.edit') }}">Ubah</a>
    </div>
</div>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">NIP</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Shift</th>
                    <th class="p-3">Status Hari Ini</th>
                    <th class="p-3">Jam Masuk</th>
                    <th class="p-3">Lokasi/Foto Masuk</th>
                    <th class="p-3">Jam Keluar</th>
                    <th class="p-3">Lokasi/Foto Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $e)
                    @php
                        $att = $attendanceToday->get($e->id);
                        $lv = $leaveToday->get($e->id);
                        $status = $lv ? 'izin' : ($att?->status ?? 'belum absen');
                    @endphp
                    <tr class="border-t">
                        <td class="p-3">{{ $e->nip }}</td>
                        <td class="p-3">{{ $e->name }}</td>
                        <td class="p-3">{{ $e->department?->nama_department }}</td>
                        <td class="p-3">{{ $e->shift?->nama_shift }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $status === 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $status === 'terlambat' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $status === 'izin' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $status === 'belum absen' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $att?->jam_masuk ?? '-' }}</td>
                        <td class="p-3">
                            @if($att && $att->jam_masuk)
                                <div class="flex flex-col gap-1 text-xs">
                                    @if($att->foto_masuk)
                                        <a href="{{ route('admin.file', ['path' => $att->foto_masuk]) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-400">No Foto</span>
                                    @endif
                                    
                                    @if($att->lokasi_masuk_lat)
                                        <a href="https://www.google.com/maps?q={{ $att->lokasi_masuk_lat }},{{ $att->lokasi_masuk_lng }}" target="_blank" class="text-blue-600 hover:underline">
                                            Maps
                                        </a>
                                    @endif
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3">{{ $att?->jam_keluar ?? '-' }}</td>
                        <td class="p-3">
                            @if($att && $att->jam_keluar)
                                <div class="flex flex-col gap-1 text-xs">
                                    @if($att->foto_keluar)
                                        <a href="{{ route('admin.file', ['path' => $att->foto_keluar]) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-400">No Foto</span>
                                    @endif
                                    
                                    @if($att->lokasi_keluar_lat)
                                        <a href="https://www.google.com/maps?q={{ $att->lokasi_keluar_lat }},{{ $att->lokasi_keluar_lng }}" target="_blank" class="text-blue-600 hover:underline">
                                            Maps
                                        </a>
                                    @endif
                                </div>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
