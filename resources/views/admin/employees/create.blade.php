@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Karyawan</h1>

<form method="POST" action="{{ route('admin.karyawan.store') }}" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">NIP</label>
            <input name="nip" value="{{ old('nip') }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('nip')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Nama</label>
            <input name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Nomor Telepon</label>
            <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('phone')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Password</label>
            <input name="password" type="password" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-sm font-medium">Position</label>
            <input name="position" value="{{ old('position') }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('position')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Department</label>
            <select name="department_id" class="mt-1 w-full border rounded-lg px-3 py-2">
                <option value="">-</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}" @selected(old('department_id') == $d->id)>{{ $d->nama_department }}</option>
                @endforeach
            </select>
            @error('department_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Shift</label>
            <select name="shift_id" class="mt-1 w-full border rounded-lg px-3 py-2">
                <option value="">-</option>
                @foreach($shifts as $s)
                    <option value="{{ $s->id }}" @selected(old('shift_id') == $s->id)>{{ $s->nama_shift }} ({{ $s->jam_masuk }}-{{ $s->jam_keluar }})</option>
                @endforeach
            </select>
            @error('shift_id')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Tanggal Masuk</label>
            <input name="tanggal_masuk" type="date" value="{{ old('tanggal_masuk') }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('tanggal_masuk')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Status</label>
            <select name="status" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>aktif</option>
                <option value="nonaktif" @selected(old('status') === 'nonaktif')>nonaktif</option>
            </select>
            @error('status')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label class="text-sm font-medium">Alamat</label>
        <textarea name="alamat" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('alamat') }}</textarea>
        @error('alamat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="text-sm font-medium">Kontak Darurat</label>
        <input name="kontak_darurat" value="{{ old('kontak_darurat') }}" class="mt-1 w-full border rounded-lg px-3 py-2">
        @error('kontak_darurat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-3">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Simpan</button>
        <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>
@endsection

