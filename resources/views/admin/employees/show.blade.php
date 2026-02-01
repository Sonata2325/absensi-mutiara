@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Karyawan</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.karyawan.edit', $employee) }}" class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">Edit Karyawan</a>
            <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 hover:text-gray-900 transition">Kembali</a>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Lengkap</div>
            <div class="font-medium text-gray-900 text-lg">{{ $employee->name }}</div>
        </div>
        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Telepon</div>
            <div class="font-medium text-gray-900 text-lg">{{ $employee->phone }}</div>
        </div>

        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Posisi</div>
            <div class="font-medium text-gray-900 text-lg">{{ $employee->position?->nama_posisi ?? '-' }}</div>
        </div>
        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Shift</div>
            <div class="font-medium text-gray-900 text-lg">{{ $employee->shift?->nama_shift ?? '-' }}</div>
        </div>
        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Masuk</div>
            <div class="font-medium text-gray-900 text-lg">{{ optional($employee->tanggal_masuk)->translatedFormat('d F Y') ?? '-' }}</div>
        </div>
        <div class="space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status</div>
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employee->status === 'aktif' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                    {{ ucfirst($employee->status) }}
                </span>
            </div>
        </div>

        <div class="md:col-span-2 space-y-1 pt-4 border-t border-gray-50">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Alamat Lengkap</div>
            <div class="font-medium text-gray-900 leading-relaxed">{{ $employee->alamat ?: '-' }}</div>
        </div>
        <div class="md:col-span-2 space-y-1">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kontak Darurat</div>
            <div class="font-medium text-gray-900">{{ $employee->kontak_darurat ?: '-' }}</div>
        </div>
        <div class="md:col-span-2 space-y-1 pt-4 border-t border-gray-50">
            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kuota Cuti Tahunan</div>
            <div class="flex flex-wrap items-center gap-3 text-gray-700">
                <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">Sisa {{ $remainingAnnual }} hari</span>
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">Terpakai {{ $usedAnnual }} hari</span>
            </div>
        </div>
    </div>
</div>
@endsection
