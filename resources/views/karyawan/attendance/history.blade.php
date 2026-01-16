@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold">Riwayat Absensi</h1>
    <a class="px-4 py-2 rounded-lg border text-sm" href="{{ route('karyawan.attendance.slip.csv', ['month' => $month, 'year' => $year]) }}">Download Slip (CSV)</a>
</div>

<form method="GET" class="bg-white border rounded-2xl p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div>
        <label class="text-sm font-medium">Bulan</label>
        <input name="month" type="number" min="1" max="12" value="{{ $month }}" class="mt-1 border rounded-lg px-3 py-2 w-24">
    </div>
    <div>
        <label class="text-sm font-medium">Tahun</label>
        <input name="year" type="number" min="2000" max="2100" value="{{ $year }}" class="mt-1 border rounded-lg px-3 py-2 w-28">
    </div>
    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Filter</button>
</form>

<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Masuk</th>
                    <th class="p-3">Keluar</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $a)
                    <tr class="border-t">
                        <td class="p-3">{{ $a->tanggal?->toDateString() }}</td>
                        <td class="p-3">{{ $a->jam_masuk }}</td>
                        <td class="p-3">{{ $a->jam_keluar }}</td>
                        <td class="p-3">{{ $a->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $attendances->links() }}</div>
@endsection

