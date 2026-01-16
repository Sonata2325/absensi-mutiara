@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Profile</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <form method="POST" action="{{ route('karyawan.profile.update') }}" enctype="multipart/form-data" class="bg-white border rounded-2xl p-6 space-y-4">
        @csrf
        <h2 class="text-lg font-bold">Update Profile</h2>

        <div>
            <label class="text-sm font-medium">Nama</label>
            <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('name')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Phone</label>
            <input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('phone')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Alamat</label>
            <textarea name="alamat" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Kontak Darurat</label>
            <input name="kontak_darurat" value="{{ old('kontak_darurat', $user->kontak_darurat) }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('kontak_darurat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Foto Profile</label>
            <input type="file" name="foto_profile" accept="image/*" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('foto_profile')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Simpan</button>
    </form>

    <form method="POST" action="{{ route('karyawan.profile.password') }}" class="bg-white border rounded-2xl p-6 space-y-4">
        @csrf
        <h2 class="text-lg font-bold">Ubah Password</h2>

        <div>
            <label class="text-sm font-medium">Password Lama</label>
            <input name="current_password" type="password" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('current_password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Password Baru</label>
            <input name="new_password" type="password" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('new_password')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Konfirmasi Password Baru</label>
            <input name="new_password_confirmation" type="password" class="mt-1 w-full border rounded-lg px-3 py-2" required>
        </div>

        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Ubah</button>
    </form>
</div>
@endsection

