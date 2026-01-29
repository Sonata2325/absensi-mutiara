@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-6">Edit Karyawan</h1>

    <form method="POST" action="{{ route('admin.karyawan.update', $employee) }}" class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input name="name" value="{{ old('name', $employee->name) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                @error('phone')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Opsional)</label>
                <input name="password" type="password" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" placeholder="Biarkan kosong jika tidak diubah">
                @error('password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Posisi</label>
                <select name="position_id" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition bg-white">
                    <option value="">Pilih Posisi</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}" @selected(old('position_id', $employee->position_id) == $p->id)>{{ $p->nama_posisi }}</option>
                    @endforeach
                </select>
                @error('position_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Shift</label>
                <select name="shift_id" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition bg-white">
                    <option value="">Pilih Shift</option>
                    @foreach($shifts as $s)
                        <option value="{{ $s->id }}" @selected(old('shift_id', $employee->shift_id) == $s->id)>{{ $s->nama_shift }} ({{ $s->jam_masuk }}-{{ $s->jam_keluar }})</option>
                    @endforeach
                </select>
                @error('shift_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                <input name="tanggal_masuk" type="date" value="{{ old('tanggal_masuk', optional($employee->tanggal_masuk)->toDateString()) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition">
                @error('tanggal_masuk')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition bg-white" required>
                    <option value="aktif" @selected(old('status', $employee->status) === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(old('status', $employee->status) === 'nonaktif')>Nonaktif</option>
                </select>
                @error('status')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
            <textarea name="alamat" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" rows="3">{{ old('alamat', $employee->alamat) }}</textarea>
            @error('alamat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kontak Darurat</label>
            <input name="kontak_darurat" value="{{ old('kontak_darurat', $employee->kontak_darurat) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition">
            @error('kontak_darurat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-50 mt-6">
            <button class="px-6 py-2.5 rounded-xl bg-gray-900 text-white font-medium shadow-sm hover:bg-gray-800 transition">Simpan Perubahan</button>
            <a href="{{ route('admin.karyawan.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition">Batal</a>
        </div>
    </form>
</div>
@endsection
