@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Office Locations -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Lokasi Kantor</h2>
            <button onclick="document.getElementById('addOfficeModal').showModal()" class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-sm hover:bg-gray-800 transition">
                + Tambah Lokasi
            </button>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">Nama Kantor</th>
                            <th class="px-6 py-4">Koordinat</th>
                            <th class="px-6 py-4">Radius</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($offices as $office)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $office->name }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $office->latitude }}, {{ $office->longitude }}
                                <a href="https://www.google.com/maps?q={{ $office->latitude }},{{ $office->longitude }}" target="_blank" class="text-blue-600 hover:underline ml-1">(Map)</a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $office->radius }} m</td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $office->address ?? '-' }}</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <button onclick="editOffice({{ $office }})" class="text-gray-400 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <form action="{{ route('admin.settings.office.destroy', $office) }}" method="POST" onsubmit="return confirm('Hapus lokasi kantor ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada lokasi kantor. Silakan tambah lokasi baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<dialog id="addOfficeModal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 m-0 rounded-3xl overflow-hidden shadow-2xl w-full max-w-lg backdrop:bg-gray-900/50 p-0">
    <div class="bg-white p-8 h-full">
        <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Tambah Lokasi Kantor</h3>
        <form method="POST" action="{{ route('admin.settings.office.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kantor</label>
                <input name="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required placeholder="Contoh: Head Office Jakarta">
            </div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                    <input name="latitude" id="add_lat" step="any" type="number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                    <input name="longitude" id="add_lng" step="any" type="number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="getGPS('add_lat', 'add_lng')" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    Ambil Lokasi Saat Ini
                </button>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Radius (meter)</label>
                <input name="radius" type="number" value="200" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition resize-none"></textarea>
            </div>
            
            <div class="flex justify-end gap-3 mt-8 pt-2">
                <button type="button" onclick="document.getElementById('addOfficeModal').close()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 shadow-lg shadow-gray-900/20 transition">Simpan</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Modal -->
<dialog id="editOfficeModal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 m-0 rounded-3xl overflow-hidden shadow-2xl w-full max-w-lg backdrop:bg-gray-900/50 p-0">
    <div class="bg-white p-8 h-full">
        <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Edit Lokasi Kantor</h3>
        <form method="POST" id="editOfficeForm" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kantor</label>
                <input name="name" id="edit_name" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
            </div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                    <input name="latitude" id="edit_lat" step="any" type="number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                    <input name="longitude" id="edit_lng" step="any" type="number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="getGPS('edit_lat', 'edit_lng')" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    Ambil Lokasi Saat Ini
                </button>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Radius (meter)</label>
                <input name="radius" id="edit_radius" type="number" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                <textarea name="address" id="edit_address" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900 transition resize-none"></textarea>
            </div>
            
            <div class="flex justify-end gap-3 mt-8 pt-2">
                <button type="button" onclick="document.getElementById('editOfficeModal').close()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 shadow-lg shadow-gray-900/20 transition">Update</button>
            </div>
        </form>
    </div>
</dialog>

<script>
function getGPS(latId, lngId) {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung GPS');
        return;
    }
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            document.getElementById(latId).value = pos.coords.latitude;
            document.getElementById(lngId).value = pos.coords.longitude;
            alert('Lokasi berhasil diambil!');
        },
        function (err) {
            alert('Gagal ambil GPS: ' + err.message);
        },
        { enableHighAccuracy: true }
    );
}

function editOffice(office) {
    document.getElementById('edit_name').value = office.name;
    document.getElementById('edit_lat').value = office.latitude;
    document.getElementById('edit_lng').value = office.longitude;
    document.getElementById('edit_radius').value = office.radius;
    document.getElementById('edit_address').value = office.address || '';
    
    // Set form action
    document.getElementById('editOfficeForm').action = "{{ route('admin.settings.office.update', ':id') }}".replace(':id', office.id);
    
    document.getElementById('editOfficeModal').showModal();
}
</script>
@endsection
