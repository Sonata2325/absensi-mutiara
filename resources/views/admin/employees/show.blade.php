@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Detail Karyawan</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.karyawan.edit', $employee) }}" class="px-4 py-2 rounded-lg border text-sm">Edit</a>
        <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 rounded-lg border text-sm">Kembali</a>
    </div>
</div>

<div class="bg-white border rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <div class="text-sm text-gray-600">NIP</div>
        <div class="font-medium">{{ $employee->nip }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Nama</div>
        <div class="font-medium">{{ $employee->name }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Email</div>
        <div class="font-medium">{{ $employee->email }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Phone</div>
        <div class="font-medium">{{ $employee->phone }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Department</div>
        <div class="font-medium">{{ $employee->department?->nama_department }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Shift</div>
        <div class="font-medium">{{ $employee->shift?->nama_shift }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Position</div>
        <div class="font-medium">{{ $employee->position }}</div>
    </div>
    <div>
        <div class="text-sm text-gray-600">Tanggal Masuk</div>
        <div class="font-medium">{{ optional($employee->tanggal_masuk)->toDateString() }}</div>
    </div>
    <div class="md:col-span-2">
        <div class="text-sm text-gray-600">Alamat</div>
        <div class="font-medium whitespace-pre-line">{{ $employee->alamat }}</div>
    </div>
    <div class="md:col-span-2">
        <div class="text-sm text-gray-600">Kontak Darurat</div>
        <div class="font-medium">{{ $employee->kontak_darurat }}</div>
    </div>
</div>
@endsection

