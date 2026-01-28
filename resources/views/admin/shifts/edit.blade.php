@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Shift</h1>

<form method="POST" action="{{ route('admin.shifts.update', $shift) }}" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_flexible" id="is_flexible" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_flexible', $shift->is_flexible) ? 'checked' : '' }}>
                <div>
                    <span class="text-sm font-medium text-gray-700">Shift Fleksibel (Tanpa Jadwal & Lokasi)</span>
                    <p class="text-xs text-gray-500">Karyawan bisa absen kapan saja dan dimana saja, namun foto & lokasi tetap tercatat.</p>
                </div>
            </label>
        </div>

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
        
        <div class="time-input">
            <label class="text-sm font-medium">Jam Masuk</label>
            <input name="jam_masuk" type="time" value="{{ old('jam_masuk', $shift->jam_masuk) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('jam_masuk')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="time-input">
            <label class="text-sm font-medium">Jam Keluar</label>
            <input name="jam_keluar" type="time" value="{{ old('jam_keluar', $shift->jam_keluar) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('jam_keluar')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="md:col-span-2">
            <label class="text-sm font-medium">Deskripsi</label>
            <textarea name="deskripsi" class="mt-1 w-full border rounded-lg px-3 py-2" rows="3">{{ old('deskripsi', $shift->deskripsi) }}</textarea>
            @error('deskripsi')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <!-- Always Active -->
        <input type="hidden" name="is_active" value="1">
    </div>

    <div class="flex items-center justify-end gap-3 mt-6">
        <a href="{{ route('admin.shifts.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm font-medium">Batal</a>
        <button type="submit" class="px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90" style="background-color: #001D3D;">Simpan</button>
    </div>
</form>

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

