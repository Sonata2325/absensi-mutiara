@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-6">Setting Sistem</h1>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
        @csrf

        <input type="hidden" name="office_lat" id="office_lat" value="{{ old('office_lat', $settings['office_lat']) }}">
        <input type="hidden" name="office_lng" id="office_lng" value="{{ old('office_lng', $settings['office_lng']) }}">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">GPS Radius (meter)</label>
            <div class="relative">
                <input name="office_radius_meters" type="number" min="1" value="{{ old('office_radius_meters', $settings['office_radius_meters']) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 text-sm">
                    meter
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Jarak maksimal toleransi lokasi absen dari titik kantor.</p>
            @error('office_radius_meters')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="pt-4 border-t border-gray-50">
            <label class="block text-sm font-medium text-gray-700 mb-3">Koordinat Kantor</label>
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="getAdminGPS()" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Ambil Lokasi Saat Ini
                </button>

                @if($settings['office_lat'] && $settings['office_lng'])
                    <a href="https://www.google.com/maps?q={{ $settings['office_lat'] }},{{ $settings['office_lng'] }}" target="_blank" class="px-4 py-2 rounded-xl border border-gray-200 text-blue-600 font-medium hover:bg-blue-50 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        Lihat di Maps
                    </a>
                @endif
            </div>
            <p class="mt-2 text-xs text-gray-500" id="location-status">
                Current: {{ $settings['office_lat'] ?? '-' }}, {{ $settings['office_lng'] ?? '-' }}
            </p>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-50 mt-6">
            <button class="px-6 py-2.5 rounded-xl bg-gray-900 text-white font-medium shadow-sm hover:bg-gray-800 transition">Simpan Pengaturan</button>
        </div>
    </form>
</div>

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

