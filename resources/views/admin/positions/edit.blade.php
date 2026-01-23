@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Posisi</h1>

<form method="POST" action="{{ route('admin.positions.update', $position) }}" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Nama Posisi</label>
            <input name="nama_posisi" value="{{ old('nama_posisi', $position->nama_posisi) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('nama_posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Kode Posisi</label>
            <input name="kode_posisi" value="{{ old('kode_posisi', $position->kode_posisi) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('kode_posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium">Deskripsi</label>
        <textarea name="deskripsi" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('deskripsi', $position->deskripsi) }}</textarea>
        @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Simpan</button>
        <a href="{{ route('admin.positions.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>
@endsection
