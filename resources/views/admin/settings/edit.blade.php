@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Setting Sistem</h1>

<form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white border rounded-2xl p-6 space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="text-sm font-medium">Jam Kerja Mulai</label>
            <input name="work_start_time" type="time" value="{{ old('work_start_time', $settings['work_start_time']) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('work_start_time')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Jam Kerja Selesai</label>
            <input name="work_end_time" type="time" value="{{ old('work_end_time', $settings['work_end_time']) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('work_end_time')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Toleransi Terlambat (menit)</label>
            <input name="late_tolerance_minutes" type="number" min="0" value="{{ old('late_tolerance_minutes', $settings['late_tolerance_minutes']) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('late_tolerance_minutes')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="text-sm font-medium">Office Latitude</label>
            <input name="office_lat" id="office_lat" value="{{ old('office_lat', $settings['office_lat']) }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('office_lat')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">Office Longitude</label>
            <input name="office_lng" id="office_lng" value="{{ old('office_lng', $settings['office_lng']) }}" class="mt-1 w-full border rounded-lg px-3 py-2">
            @error('office_lng')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="text-sm font-medium">GPS Radius (meter)</label>
            <input name="office_radius_meters" type="number" min="1" value="{{ old('office_radius_meters', $settings['office_radius_meters']) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            @error('office_radius_meters')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
    </div>

    <button type="button" onclick="getAdminGPS()" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 mr-2">
        Ambil Lokasi Saat Ini
    </button>
    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white">Simpan</button>
</form>

<script>
function getAdminGPS() {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung GPS');
        return;
    }
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            document.getElementById('office_lat').value = pos.coords.latitude;
            document.getElementById('office_lng').value = pos.coords.longitude;
            alert('Lokasi berhasil diambil!');
        },
        function (err) {
            alert('Gagal ambil GPS: ' + err.message);
        },
        { enableHighAccuracy: true }
    );
}
</script>
@endsection

