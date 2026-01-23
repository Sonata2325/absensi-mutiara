@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Kehadiran</h1>
        <p class="text-gray-500 mt-1 text-sm">Rekap data kehadiran per periode</p>
    </div>
    <div class="flex gap-2">
        <a class="px-4 py-2 rounded-xl border text-sm font-semibold text-gray-700 hover:bg-gray-50" href="{{ route('admin.reports.attendance.csv', ['month' => $month, 'year' => $year]) }}">Export Excel (CSV)</a>
        <a class="px-4 py-2 rounded-xl border text-sm font-semibold text-gray-700 hover:bg-gray-50" href="{{ route('admin.reports.attendance.pdf', ['month' => $month, 'year' => $year]) }}" target="_blank">Export PDF</a>
    </div>
</div>

<form method="GET" class="bg-white border border-gray-100 rounded-2xl p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div>
        <label class="text-sm font-medium">Bulan</label>
        <input name="month" type="number" min="1" max="12" value="{{ $month }}" class="mt-1 border rounded-lg px-3 py-2 w-24 focus:ring-[#D61600] focus:border-[#D61600]">
    </div>
    <div>
        <label class="text-sm font-medium">Tahun</label>
        <input name="year" type="number" min="2000" max="2100" value="{{ $year }}" class="mt-1 border rounded-lg px-3 py-2 w-28 focus:ring-[#D61600] focus:border-[#D61600]">
    </div>
    <button class="px-4 py-2 rounded-xl bg-[#D61600] text-white text-sm font-semibold hover:bg-[#b01200]">Filter</button>
</form>

<div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Posisi</th>
                    <th class="p-3">Shift</th>
                    <th class="p-3">Masuk</th>
                    <th class="p-3">Keluar</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $a)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $a->tanggal?->toDateString() }}</td>
                        <td class="p-3">{{ $a->employee?->name }}</td>
                        <td class="p-3">{{ $a->employee?->position?->nama_posisi }}</td>
                        <td class="p-3">{{ $a->employee?->shift?->nama_shift }}</td>
                        <td class="p-3">{{ $a->jam_masuk }}</td>
                        <td class="p-3">{{ $a->jam_keluar }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $a->status === 'hadir' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : '' }}
                                {{ $a->status === 'terlambat' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200' : '' }}
                                {{ $a->status === 'alpha' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : '' }}
                            ">
                                {{ $a->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-6 text-gray-600" colspan="8">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
