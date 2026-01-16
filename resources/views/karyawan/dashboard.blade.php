@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Karyawan</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border rounded-2xl p-4">
        <div class="text-sm text-gray-600">Status Absensi Hari Ini</div>
        <div class="text-xl font-bold">
            @if($leaveToday)
                izin
            @elseif($attendanceToday)
                {{ $attendanceToday->status }}
            @else
                belum absen
            @endif
        </div>
    </div>
    <div class="bg-white border rounded-2xl p-4">
        <div class="text-sm text-gray-600">Riwayat Bulan Ini</div>
        <div class="text-sm mt-2">
            Hadir: <span class="font-bold">{{ (int) ($summary->hadir ?? 0) }}</span><br>
            Terlambat: <span class="font-bold">{{ (int) ($summary->terlambat ?? 0) }}</span><br>
            Alpha: <span class="font-bold">{{ (int) ($summary->alpha ?? 0) }}</span>
        </div>
    </div>
    <div class="bg-white border rounded-2xl p-4">
        <div class="text-sm text-gray-600">Pengajuan Izin Disetujui (Tahun Ini)</div>
        <div class="text-2xl font-bold">{{ $usedLeaveThisYear }}</div>
    </div>
</div>

<div class="flex flex-wrap gap-3">
    <a href="{{ route('karyawan.attendance.index') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm">Clock In/Out</a>
    <a href="{{ route('karyawan.attendance.history') }}" class="px-4 py-2 rounded-lg border text-sm">Riwayat Absensi</a>
    <a href="{{ route('karyawan.leave.create') }}" class="px-4 py-2 rounded-lg border text-sm">Ajukan Izin</a>
</div>
@endsection

