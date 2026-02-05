@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Kehadiran</h1>
        <p class="text-gray-500 mt-1 text-sm">Rekap data kehadiran per periode</p>
    </div>
    <div class="flex gap-2">
        <a class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition" href="{{ route('admin.reports.attendance.csv', ['month' => $month, 'year' => $year]) }}">Export Excel (CSV)</a>
        <a class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition" href="{{ route('admin.reports.attendance.pdf', ['month' => $month, 'year' => $year]) }}" target="_blank">Export PDF</a>
    </div>
</div>

<form method="GET" class="bg-white border border-gray-100 rounded-2xl p-6 mb-6 flex flex-wrap gap-4 items-end shadow-sm">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Bulan</label>
        <input name="month" type="number" min="1" max="12" value="{{ $month }}" class="w-24 border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun</label>
        <input name="year" type="number" min="2000" max="2100" value="{{ $year }}" class="w-28 border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition">
    </div>
    <button class="px-6 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">Filter Data</button>
</form>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium">Nama</th>
                    <th class="px-6 py-4 font-medium">Posisi</th>
                    <th class="px-6 py-4 font-medium">Shift</th>
                    <th class="px-6 py-4 font-medium">Masuk</th>
                    <th class="px-6 py-4 font-medium">Keluar</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium">Overtime</th>
                    <th class="px-6 py-4 font-medium">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($attendances as $a)
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $a->tanggal?->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $a->employee?->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $a->employee?->position?->nama_posisi }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $a->employee?->shift?->nama_shift }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $a->jam_masuk }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $a->jam_keluar }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $a->status === 'hadir' ? 'bg-green-50 text-green-700 ring-1 ring-green-200/50' : '' }}
                                {{ $a->status === 'terlambat' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200/50' : '' }}
                                {{ $a->status === 'alpha' ? 'bg-red-50 text-red-700 ring-1 ring-red-200/50' : '' }}
                                {{ $a->status === 'overtime' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/50' : '' }}
                            ">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($a->status === 'overtime')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-200/50">
                                    Ya
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $a->keterangan ?? '' }}">
                            {{ $a->keterangan ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-8 text-center text-gray-500" colspan="9">Belum ada data absensi untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
