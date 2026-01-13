@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.trucks.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Daftar Truck
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Truck</h1>
            </div>

            <div class="bg-white border rounded-2xl shadow-sm p-6 md:p-8">
                <form action="{{ route('admin.trucks.update', $truck) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="plat_nomor" value="{{ old('plat_nomor', $truck->plat_nomor) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        @error('plat_nomor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_armada" class="block text-sm font-medium text-gray-700 mb-1">Jenis Armada</label>
                        <select name="jenis_armada" id="jenis_armada" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="cde" {{ old('jenis_armada', $truck->jenis_armada) == 'cde' ? 'selected' : '' }}>CDE (Engkel)</option>
                            <option value="cdd" {{ old('jenis_armada', $truck->jenis_armada) == 'cdd' ? 'selected' : '' }}>CDD (Double)</option>
                            <option value="fuso" {{ old('jenis_armada', $truck->jenis_armada) == 'fuso' ? 'selected' : '' }}>Fuso</option>
                            <option value="tronton_wingbox" {{ old('jenis_armada', $truck->jenis_armada) == 'tronton_wingbox' ? 'selected' : '' }}>Tronton Wingbox</option>
                        </select>
                        @error('jenis_armada')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kapasitas_kg" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Kg)</label>
                        <input type="number" name="kapasitas_kg" id="kapasitas_kg" value="{{ old('kapasitas_kg', $truck->kapasitas_kg) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" min="1" required>
                        @error('kapasitas_kg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="tersedia" {{ old('status', $truck->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dalam_perjalanan" {{ old('status', $truck->status) == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                            <option value="perbaikan" {{ old('status', $truck->status) == 'perbaikan' ? 'selected' : '' }}>Perbaikan (Maintenance)</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Perhatian: Mengubah status secara manual dapat mempengaruhi operasional.</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Simpan Perubahan</button>
                        <a href="{{ route('admin.trucks.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
