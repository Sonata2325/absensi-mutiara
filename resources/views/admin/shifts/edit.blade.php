@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Shift</h1>

<form method="POST" action="{{ route('admin.shifts.update', $shift) }}" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Nama Shift</label>
            <input name="nama_shift" value="{{ old('nama_shift', $shift->nama_shift) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('nama_shift')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Toleransi Terlambat (menit)</label>
            <input name="toleransi_terlambat" type="number" value="{{ old('toleransi_terlambat', $shift->toleransi_terlambat) }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('toleransi_terlambat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Jam Masuk</label>
            <input name="jam_masuk" type="time" value="{{ old('jam_masuk', $shift->jam_masuk) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('jam_masuk')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Jam Keluar</label>
            <input name="jam_keluar" type="time" value="{{ old('jam_keluar', $shift->jam_keluar) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('jam_keluar')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium">Deskripsi</label>
        <textarea name="deskripsi" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('deskripsi', $shift->deskripsi) }}</textarea>
        @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $shift->is_active))>
        Aktif
    </label>

    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Simpan</button>
        <a href="{{ route('admin.shifts.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>
@endsection

