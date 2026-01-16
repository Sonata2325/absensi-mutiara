@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Form Pengajuan Izin/Cuti</h1>

<form method="POST" action="{{ route('karyawan.leave.store') }}" enctype="multipart/form-data" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Tipe</label>
            <select name="tipe" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                <option value="sakit" @selected(old('tipe') === 'sakit')>sakit</option>
                <option value="cuti" @selected(old('tipe') === 'cuti')>cuti</option>
                <option value="izin" @selected(old('tipe') === 'izin')>izin</option>
            </select>
            @error('tipe')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Dokumen Pendukung (opsional)</label>
            <input type="file" name="dokumen_pendukung" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('dokumen_pendukung')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Tanggal Mulai</label>
            <input name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai') }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('tanggal_mulai')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Tanggal Selesai</label>
            <input name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai') }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('tanggal_selesai')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium">Alasan</label>
        <textarea name="alasan" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('alasan') }}</textarea>
        @error('alasan')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Submit</button>
        <a href="{{ route('karyawan.leave.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>
@endsection

