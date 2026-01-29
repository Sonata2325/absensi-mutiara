@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-6">Edit Shift</h1>

    <form method="POST" action="{{ route('admin.shifts.update', $shift) }}" class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="is_flexible" id="is_flexible" value="1" class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900/10 focus:ring-opacity-50 transition" {{ old('is_flexible', $shift->is_flexible) ? 'checked' : '' }}>
                    <div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition">Shift Fleksibel (Tanpa Jadwal & Lokasi)</span>
                        <p class="text-xs text-gray-500">Karyawan bisa absen kapan saja dan dimana saja, namun foto & lokasi tetap tercatat.</p>
                    </div>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Shift</label>
                <input name="nama_shift" value="{{ old('nama_shift', $shift->nama_shift) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                @error('nama_shift')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Toleransi Terlambat (menit)</label>
                <input name="toleransi_terlambat" type="number" value="{{ old('toleransi_terlambat', $shift->toleransi_terlambat) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition">
                @error('toleransi_terlambat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="time-input">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Masuk</label>
                <input name="jam_masuk" type="time" value="{{ old('jam_masuk', $shift->jam_masuk) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                @error('jam_masuk')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="time-input">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Keluar</label>
                <input name="jam_keluar" type="time" value="{{ old('jam_keluar', $shift->jam_keluar) }}" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                @error('jam_keluar')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" rows="3">{{ old('deskripsi', $shift->deskripsi) }}</textarea>
                @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
            </div>
            
            <!-- Always Active -->
            <input type="hidden" name="is_active" value="1">
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-50 mt-6">
            <button class="px-6 py-2.5 rounded-xl bg-gray-900 text-white font-medium shadow-sm hover:bg-gray-800 transition">Simpan Perubahan</button>
            <a href="{{ route('admin.shifts.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition">Batal</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isFlexible = document.getElementById('is_flexible');
        const timeInputs = document.querySelectorAll('.time-input');
        const jamInputs = document.querySelectorAll('input[type="time"]');

        function toggleTimeInputs() {
            if (isFlexible.checked) {
                timeInputs.forEach(el => el.style.display = 'none');
                jamInputs.forEach(el => el.removeAttribute('required'));
            } else {
                timeInputs.forEach(el => el.style.display = 'block');
                jamInputs.forEach(el => el.setAttribute('required', 'required'));
            }
        }

        isFlexible.addEventListener('change', toggleTimeInputs);
        toggleTimeInputs(); // Initial check
    });
</script>
@endsection

