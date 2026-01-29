@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-6">Tambah Posisi</h1>

    <form method="POST" action="{{ route('admin.positions.store') }}" class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Posisi</label>
                <input name="nama_posisi" value="{{ old('nama_posisi') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required placeholder="Contoh: Staff IT">
                @error('nama_posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Posisi</label>
                <input name="kode_posisi" value="{{ old('kode_posisi') }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required placeholder="Contoh: IT-01">
                @error('kode_posisi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" rows="3" placeholder="Deskripsi singkat tentang posisi ini">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-50 mt-6">
            <button class="px-6 py-2.5 rounded-xl bg-gray-900 text-white font-medium shadow-sm hover:bg-gray-800 transition">Simpan Posisi</button>
            <a href="{{ route('admin.positions.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition">Batal</a>
        </div>
    </form>
</div>
@endsection
