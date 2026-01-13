@extends('layouts.app')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Scan & Grouping Barang ke Truck</h1>
                    <p class="mt-2 text-gray-600">Pilih truck, assign driver, lalu scan QR atau input resi untuk memasukkan barang ke grup.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.orders.new') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Pesanan Baru</a>
                    <a href="{{ route('admin.shipments.active') }}" class="px-5 py-3 rounded-lg border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">Shipment Aktif</a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-900 rounded-xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900 mb-4">Step 1: Pilih Truck</div>
                        <form method="POST" action="{{ route('admin.grouping.start') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Truck</label>
                                    <select name="truck_id" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">Pilih truck</option>
                                        @foreach($trucks as $t)
                                            <option value="{{ $t->id }}" @selected(optional($selectedTruck)->id === $t->id) @disabled($t->status !== 'tersedia')>
                                                {{ $t->plat_nomor }} - {{ $t->jenis_armada }} ({{ $t->status }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-xs text-gray-500 mt-1">Hanya truck dengan status tersedia bisa dipilih.</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Driver Assigned</label>
                                    <select name="driver_id" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">Pilih driver</option>
                                        @foreach($drivers as $d)
                                            <option value="{{ $d->id }}" @disabled($d->status === 'sedang_bertugas') @selected(optional($session)->driver_id === $d->id)>
                                                {{ $d->nama }} ({{ $d->telepon }}) - {{ $d->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-xs text-gray-500 mt-1">Driver dengan status sedang_bertugas tidak bisa dipilih.</div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-6 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Set Truck</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div class="font-bold text-gray-900">Step 2: Scan QR Code Barang</div>
                            <div class="text-sm text-gray-600">
                                @if($selectedTruck)
                                    Truck dipilih: <span class="font-semibold">{{ $selectedTruck->plat_nomor }} - {{ $selectedTruck->jenis_armada }}</span>
                                @else
                                    Belum memilih truck
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 border rounded-2xl p-4">
                                <div class="font-semibold text-gray-900">Scanner Kamera</div>
                                <div class="mt-3">
                                    <div id="qr-reader" class="w-full"></div>
                                </div>
                                <div class="mt-4 flex gap-3">
                                    <button type="button" class="px-4 py-2 rounded-lg bg-gray-900 hover:bg-black text-white font-semibold transition" id="startScannerBtn">Aktifkan Scanner</button>
                                    <button type="button" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition" id="stopScannerBtn">Stop</button>
                                </div>
                                <div class="mt-3 text-xs text-gray-600">Pastikan browser mengizinkan akses kamera.</div>
                            </div>

                            <div class="bg-gray-50 border rounded-2xl p-4">
                                <div class="font-semibold text-gray-900">Mode Manual Input</div>
                                <form method="POST" action="{{ route('admin.grouping.add') }}" class="mt-3 space-y-3" id="addForm">
                                    @csrf
                                    <input type="hidden" name="truck_id" value="{{ optional($selectedTruck)->id }}">
                                    <input type="hidden" name="force" id="forceInput" value="0">
                                    <input type="hidden" name="qr_raw" id="qrRawInput">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                        <input name="admin_nama" id="adminNama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Contoh: Budi Santoso">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Resi</label>
                                        <input name="resi" id="resiInput" type="text" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan nomor resi">
                                    </div>
                                    <label class="inline-flex items-center gap-2 text-gray-700 font-semibold">
                                        <input type="checkbox" id="forceCheckbox" class="w-4 h-4 text-primary border-gray-300 rounded">
                                        Override jika armada tidak cocok
                                    </label>
                                    <div class="flex justify-end">
                                        <button class="px-6 py-3 rounded-lg bg-primary hover:bg-blue-800 text-white font-bold transition">Tambahkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="font-bold text-gray-900">Barang yang Sudah Di-scan</div>
                                <div class="text-gray-600 mt-1">
                                    Total: <span class="font-semibold">{{ $orders->count() }}</span> barang
                                    @if($selectedTruck && $selectedTruck->kapasitas_kg)
                                        , Total berat: <span class="font-semibold">{{ rtrim(rtrim((string) $totalWeight, '0'), '.') }} kg</span>
                                        , Kapasitas: <span class="font-semibold">{{ $selectedTruck->kapasitas_kg }} kg</span>
                                    @endif
                                </div>
                            </div>
                            @if($selectedTruck && $session)
                                <form method="POST" action="{{ route('admin.grouping.depart') }}" class="flex flex-col md:flex-row gap-3 items-stretch md:items-end">
                                    @csrf
                                    <input type="hidden" name="truck_id" value="{{ $selectedTruck->id }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
                                        <input name="admin_nama" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Contoh: Budi Santoso">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Estimasi Berangkat</label>
                                        <input name="waktu_berangkat" type="datetime-local" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <button class="px-6 py-3 rounded-lg bg-gray-900 hover:bg-black text-white font-bold transition">
                                        Berangkatkan Truck - {{ $orders->count() }} Barang
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if($selectedTruck && $selectedTruck->kapasitas_kg)
                            @php
                                $overload = $totalWeight > (float) $selectedTruck->kapasitas_kg;
                                $near = !$overload && $totalWeight >= (float) $selectedTruck->kapasitas_kg * 0.9;
                            @endphp
                            @if($overload || $near)
                                <div class="mt-4 rounded-xl border p-4 {{ $overload ? 'bg-red-50 border-red-200 text-red-900' : 'bg-yellow-50 border-yellow-200 text-yellow-900' }}">
                                    @if($overload)
                                        Total berat melebihi kapasitas truck.
                                    @else
                                        Total berat mendekati kapasitas truck.
                                    @endif
                                </div>
                            @endif
                        @endif

                        <div class="mt-5 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-gray-700">
                                    <tr>
                                        <th class="text-left font-semibold px-4 py-3">No</th>
                                        <th class="text-left font-semibold px-4 py-3">Resi</th>
                                        <th class="text-left font-semibold px-4 py-3">Pengirim</th>
                                        <th class="text-left font-semibold px-4 py-3">Tujuan</th>
                                        <th class="text-left font-semibold px-4 py-3">Berat</th>
                                        <th class="text-right font-semibold px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse($orders as $i => $o)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-gray-700">{{ $i + 1 }}</td>
                                            <td class="px-4 py-3 font-bold text-gray-900 whitespace-nowrap">{{ $o->nomor_resi }}</td>
                                            <td class="px-4 py-3 text-gray-700 max-w-xs">{{ $o->pengirim_nama ?: '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700 max-w-xs">{{ $o->penerima_alamat }}</td>
                                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap">{{ rtrim(rtrim((string) $o->berat_kg, '0'), '.') }} kg</td>
                                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                                <form method="POST" action="{{ route('admin.grouping.remove') }}">
                                                    @csrf
                                                    <input type="hidden" name="truck_id" value="{{ optional($selectedTruck)->id }}">
                                                    <input type="hidden" name="order_id" value="{{ $o->id }}">
                                                    <input type="hidden" name="admin_nama" value="" class="adminNameField">
                                                    <button class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-gray-600">Belum ada barang yang di-scan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900">Petunjuk</div>
                        <div class="mt-3 text-gray-700 space-y-2">
                            <div>1. Pilih truck dengan status tersedia dan assign driver.</div>
                            <div>2. Scan QR atau input resi untuk menambahkan ke grup.</div>
                            <div>3. Klik berangkatkan untuk memulai pengiriman.</div>
                        </div>
                    </div>

                    <div class="bg-white border rounded-2xl p-6 shadow-sm">
                        <div class="font-bold text-gray-900">Status Truck</div>
                        <div class="mt-4 space-y-2 text-gray-800">
                            @foreach($trucks as $t)
                                <div class="flex items-center justify-between gap-3 bg-gray-50 border rounded-xl p-3">
                                    <div class="font-semibold">{{ $t->plat_nomor }}</div>
                                    <div class="text-sm text-gray-600">{{ $t->status }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    (function () {
        const startBtn = document.getElementById('startScannerBtn');
        const stopBtn = document.getElementById('stopScannerBtn');
        const resiInput = document.getElementById('resiInput');
        const addForm = document.getElementById('addForm');
        const adminNamaInput = document.getElementById('adminNama');
        const forceCheckbox = document.getElementById('forceCheckbox');
        const forceInput = document.getElementById('forceInput');
        const qrRawInput = document.getElementById('qrRawInput');

        if (forceCheckbox && forceInput) {
            forceCheckbox.addEventListener('change', () => {
                forceInput.value = forceCheckbox.checked ? '1' : '0';
            });
        }

        const selectedTruckId = @json(optional($selectedTruck)->id);
        let qrScanner = null;

        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => {
                const name = adminNamaInput?.value || '';
                form.querySelectorAll('.adminNameField').forEach((el) => {
                    el.value = name;
                });
            });
        });

        function parseResiFromPayload(text) {
            try {
                const obj = JSON.parse(text);
                if (obj && typeof obj.resi === 'string') return obj.resi;
            } catch (e) {}
            return text;
        }

        function canScan() {
            return !!selectedTruckId;
        }

        startBtn?.addEventListener('click', async () => {
            if (!canScan()) {
                alert('Pilih truck terlebih dahulu.');
                return;
            }
            if (!window.Html5Qrcode) {
                alert('Scanner belum siap.');
                return;
            }
            if (!qrScanner) {
                qrScanner = new Html5Qrcode('qr-reader');
            }
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            try {
                const cameras = await Html5Qrcode.getCameras();
                const cameraId = cameras && cameras.length ? cameras[0].id : null;
                if (!cameraId) {
                    alert('Kamera tidak ditemukan.');
                    return;
                }
                await qrScanner.start(cameraId, config, (decodedText) => {
                    if (qrRawInput) qrRawInput.value = decodedText;
                    const resi = parseResiFromPayload(decodedText || '');
                    if (resiInput) resiInput.value = resi;
                    if (addForm) addForm.submit();
                    qrScanner.stop().catch(() => {});
                });
            } catch (err) {
                alert('Gagal mengaktifkan kamera.');
            }
        });

        stopBtn?.addEventListener('click', async () => {
            if (qrScanner) {
                try {
                    await qrScanner.stop();
                } catch (e) {}
            }
        });
    })();
</script>
@endsection
