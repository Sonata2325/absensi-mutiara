@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto">
    <!-- Header Summary -->
    <div class="bg-white rounded-3xl shadow-sm p-6 mb-6 text-center">
        <h1 class="text-xl font-bold text-gray-800 mb-1">Halo, {{ auth()->user()->name }}</h1>
        <p class="text-gray-500 text-sm">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        
        <div class="mt-6 grid grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-2xl">
                <div class="text-xs text-blue-600 font-bold uppercase tracking-wider">Jam Masuk</div>
                <div class="text-xl font-bold text-blue-900 mt-1">{{ $attendance?->jam_masuk ?? '--:--' }}</div>
            </div>
            <div class="bg-orange-50 p-4 rounded-2xl">
                <div class="text-xs text-orange-600 font-bold uppercase tracking-wider">Jam Keluar</div>
                <div class="text-xl font-bold text-orange-900 mt-1">{{ $attendance?->jam_keluar ?? '--:--' }}</div>
            </div>
        </div>
    </div>

    <!-- Main Action Area -->
    <div class="mb-6">
        @if($leaveToday)
            <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h2 class="text-xl font-bold text-yellow-800">Sedang Cuti</h2>
                <p class="text-yellow-600 mt-2">Anda sedang dalam masa cuti hari ini. Tidak perlu melakukan absensi.</p>
            </div>
        
        @elseif(!$attendance)
            <!-- State: Belum Absen -->
            <button onclick="openCamera('in')" class="w-full bg-blue-600 active:bg-blue-700 text-white rounded-3xl p-6 shadow-lg transform transition active:scale-95 flex flex-col items-center justify-center gap-3 group">
                <div class="p-4 bg-white/20 rounded-full group-hover:bg-white/30 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">CLOCK IN</div>
                    <div class="text-blue-100 text-sm">Mulai jam kerja Anda</div>
                </div>
            </button>

        @elseif($attendance->jam_masuk && !$attendance->jam_keluar)
            <!-- State: Sudah Absen Masuk, Belum Keluar -->
            <div class="bg-green-50 border border-green-200 rounded-3xl p-6 mb-4 text-center">
                <div class="text-green-800 font-medium">Anda sudah absen masuk</div>
                <div class="text-3xl font-bold text-green-900 mt-1">{{ $attendance->jam_masuk }}</div>
            </div>

            <button onclick="openCamera('out')" class="w-full bg-red-600 active:bg-red-700 text-white rounded-3xl p-6 shadow-lg transform transition active:scale-95 flex flex-col items-center justify-center gap-3 group">
                <div class="p-4 bg-white/20 rounded-full group-hover:bg-white/30 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">CLOCK OUT</div>
                    <div class="text-red-100 text-sm">Akhiri jam kerja Anda</div>
                </div>
            </button>

        @else
            <!-- State: Sudah Selesai -->
            <div class="bg-gray-100 rounded-3xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Absensi Selesai</h2>
                <p class="text-gray-600 mt-2">Terima kasih atas kerja keras Anda hari ini!</p>
                <div class="mt-4 text-sm text-gray-500">
                    Masuk: {{ $attendance->jam_masuk }} • Keluar: {{ $attendance->jam_keluar }}
                </div>
            </div>
        @endif
    </div>

    <!-- Location Info -->
    <div class="text-center text-xs text-gray-400">
        Office Location: {{ $settings['office_lat'] ?? '-' }}, {{ $settings['office_lng'] ?? '-' }}
    </div>
</div>

<!-- Fullscreen Camera Modal -->
<div id="camera-modal" class="fixed inset-0 bg-black z-[60] hidden flex flex-col">
    <!-- Camera Header -->
    <div class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center z-10 bg-gradient-to-b from-black/50 to-transparent">
        <button onclick="closeCamera()" class="text-white p-2 hover:bg-white/10 rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="text-white font-medium text-lg" id="modal-title">Ambil Foto</div>
        <button onclick="switchCamera()" class="text-white p-2 hover:bg-white/10 rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
        </button>
    </div>

    <!-- Video Feed -->
    <div class="flex-1 relative bg-black flex items-center justify-center overflow-hidden">
        <video id="video-feed" autoplay playsinline class="w-full h-full object-cover"></video>
        <canvas id="canvas-process" class="hidden"></canvas>
        <img id="photo-preview" class="hidden w-full h-full object-cover absolute inset-0 z-20">
        
        <!-- Loading Overlay -->
        <div id="loading-overlay" class="absolute inset-0 z-30 bg-black/50 flex flex-col items-center justify-center hidden">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white border-t-transparent mb-3"></div>
            <div class="text-white font-medium">Memproses Lokasi...</div>
        </div>
    </div>

    <!-- Camera Controls -->
    <div class="bg-black p-6 pb-10 flex flex-col items-center gap-4">
        <!-- Capture Button -->
        <button id="btn-capture" onclick="takeSnapshot()" class="w-20 h-20 rounded-full border-4 border-white flex items-center justify-center mb-4 active:scale-95 transition hover:bg-white/10">
            <div class="w-16 h-16 bg-white rounded-full pointer-events-none"></div>
        </button>

        <!-- Preview Actions (Hidden by default) -->
        <div id="preview-actions" class="hidden w-full flex flex-col gap-3 max-w-sm">
            <div class="flex items-center justify-center gap-2 text-white text-sm mb-2 bg-green-500/20 py-2 rounded-lg border border-green-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Lokasi & Waktu berhasil ditambahkan
            </div>
            
            <form id="attendance-form" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <input type="hidden" name="lat" id="form-lat">
                <input type="hidden" name="lng" id="form-lng">
                <input type="file" name="photo" id="form-file" class="hidden"> 
                
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl text-lg shadow-lg active:bg-blue-700 hover:bg-blue-500 transition flex items-center justify-center gap-2">
                    <span>Kirim Absensi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>

            <button onclick="resetCamera()" class="text-white py-3 font-medium hover:text-gray-300 transition">Foto Ulang</button>
        </div>
    </div>
</div>

<script>
    let currentStream = null;
    let facingMode = 'user';
    let currentType = 'in'; // 'in' or 'out'

    function openCamera(type) {
        currentType = type;
        document.getElementById('modal-title').innerText = type === 'in' ? 'Clock In Selfie' : 'Clock Out Selfie';
        document.getElementById('camera-modal').classList.remove('hidden');
        
        // Prepare form action and input name
        const form = document.getElementById('attendance-form');
        const fileInput = document.getElementById('form-file');
        
        if (type === 'in') {
            form.action = "{{ route('karyawan.attendance.clock_in') }}";
            fileInput.name = "foto_masuk";
        } else {
            form.action = "{{ route('karyawan.attendance.clock_out') }}";
            fileInput.name = "foto_keluar";
        }

        startCamera();
    }

    function closeCamera() {
        stopStream();
        document.getElementById('camera-modal').classList.add('hidden');
        resetCamera();
    }

    async function startCamera() {
        try {
            if (currentStream) stopStream();
            
            const constraints = {
                video: { 
                    facingMode: facingMode,
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            };
            
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            const video = document.getElementById('video-feed');
            video.srcObject = stream;
            currentStream = stream;
        } catch (err) {
            alert('Gagal membuka kamera: ' + err.message);
            closeCamera();
        }
    }

    function stopStream() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
    }

    async function switchCamera() {
        facingMode = facingMode === 'user' ? 'environment' : 'user';
        await startCamera();
    }

    function takeSnapshot() {
        if (!navigator.geolocation) {
            alert('Browser tidak mendukung GPS');
            return;
        }

        const btnCapture = document.getElementById('btn-capture');
        const loadingOverlay = document.getElementById('loading-overlay');
        
        // Show loading state
        loadingOverlay.classList.remove('hidden');
        btnCapture.classList.add('opacity-0', 'pointer-events-none');

        navigator.geolocation.getCurrentPosition(
            (pos) => processImage(pos.coords.latitude, pos.coords.longitude),
            (err) => {
                loadingOverlay.classList.add('hidden');
                btnCapture.classList.remove('opacity-0', 'pointer-events-none');
                
                let msg = 'Gagal mengambil lokasi.';
                if (err.code === 1) msg = 'Izin lokasi ditolak. Harap aktifkan GPS.';
                else if (err.code === 2) msg = 'Lokasi tidak tersedia.';
                else if (err.code === 3) msg = 'Timeout saat mengambil lokasi.';
                
                alert(msg);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    function processImage(lat, lng) {
        const video = document.getElementById('video-feed');
        const canvas = document.getElementById('canvas-process');
        const preview = document.getElementById('photo-preview');
        const loadingOverlay = document.getElementById('loading-overlay');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        const ctx = canvas.getContext('2d');
        
        // Flip horizontally if using front camera to mirror user experience
        if (facingMode === 'user') {
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
        }
        
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Reset transform for text
        ctx.setTransform(1, 0, 0, 1, 0, 0);

        // Add Gradient Background for Text
        const gradient = ctx.createLinearGradient(0, canvas.height - 200, 0, canvas.height);
        gradient.addColorStop(0, 'transparent');
        gradient.addColorStop(1, 'rgba(0,0,0,0.9)');
        
        ctx.fillStyle = gradient;
        ctx.fillRect(0, canvas.height - 250, canvas.width, 250);
        
        // Add Text Watermark
        const timestamp = new Date().toLocaleString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
        
        // Responsive font size calculation
        const baseFontSize = Math.max(24, Math.floor(canvas.width / 25));
        
        ctx.fillStyle = 'white';
        ctx.font = `bold ${baseFontSize}px sans-serif`;
        ctx.fillText(timestamp, 40, canvas.height - 80);
        
        ctx.font = `${baseFontSize * 0.7}px sans-serif`;
        ctx.fillText(`Lat: ${lat}`, 40, canvas.height - 45);
        ctx.fillText(`Lng: ${lng}`, 40, canvas.height - 15);

        // Show preview
        const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
        preview.src = dataUrl;
        preview.classList.remove('hidden');
        
        // Hide loading, show actions
        loadingOverlay.classList.add('hidden');
        document.getElementById('preview-actions').classList.remove('hidden');
        
        // Set form values
        document.getElementById('form-lat').value = lat;
        document.getElementById('form-lng').value = lng;
        
        // Create file object
        canvas.toBlob(blob => {
            const file = new File([blob], "attendance.jpg", { type: "image/jpeg" });
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('form-file').files = dt.files;
        }, 'image/jpeg', 0.85);
    }

    function resetCamera() {
        document.getElementById('photo-preview').classList.add('hidden');
        document.getElementById('preview-actions').classList.add('hidden');
        document.getElementById('btn-capture').classList.remove('hidden', 'opacity-0', 'pointer-events-none');
        document.getElementById('loading-overlay').classList.add('hidden');
        startCamera();
    }
</script>
@endsection

