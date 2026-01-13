@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.drivers.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Daftar Driver
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Driver</h1>
            </div>

            <div class="bg-white border rounded-2xl shadow-sm p-6 md:p-8">
                <form action="{{ route('admin.drivers.update', $driver) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $driver->nama) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon (WA)</label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $driver->telepon) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_sim" class="block text-sm font-medium text-gray-700 mb-1">Nomor SIM</label>
                        <input type="text" name="nomor_sim" id="nomor_sim" value="{{ old('nomor_sim', $driver->nomor_sim) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('nomor_sim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="aktif" {{ old('status', $driver->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="sedang_bertugas" {{ old('status', $driver->status) == 'sedang_bertugas' ? 'selected' : '' }}>Sedang Bertugas</option>
                            <option value="nonaktif" {{ old('status', $driver->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif (Cuti/Keluar)</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Perhatian: Mengubah status secara manual dapat mempengaruhi operasional.</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Simpan Perubahan</button>
                        <a href="{{ route('admin.drivers.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
