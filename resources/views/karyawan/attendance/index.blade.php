@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto space-y-8">
    <!-- Header Section -->
    <div class="text-center pt-4">
        <h1 class="text-4xl font-bold text-[#D61600] tracking-tight mb-2">{{ now()->format('H:i') }}</h1>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#D61600]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span class="text-sm font-medium text-[#D61600]">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>

    <!-- Attendance Stats -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Jam Masuk -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 transition-transform hover:scale-[1.02]">
            <div class="p-3 bg-red-50 rounded-full text-[#D61600]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            </div>
            <div class="text-center">
                <span class="block text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Jam Masuk</span>
                <span class="block text-xl font-bold text-gray-800">{{ $attendance?->jam_masuk ?? '--:--' }}</span>
            </div>
        </div>

        <!-- Jam Keluar -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 transition-transform hover:scale-[1.02]">
            <div class="p-3 bg-red-50 rounded-full text-[#D61600]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
            </div>
            <div class="text-center">
                <span class="block text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Jam Keluar</span>
                <span class="block text-xl font-bold text-gray-800">{{ $attendance?->jam_keluar ?? '--:--' }}</span>
            </div>
        </div>
    </div>

    <!-- Main Action Area -->
    <div class="relative">
        @if($leaveToday)
            <!-- State: Sedang Cuti -->
            <div class="bg-orange-50 border border-orange-100 rounded-3xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4 text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Sedang Cuti</h2>
                <p class="text-gray-500 mt-2 text-sm">Anda sedang dalam masa cuti hari ini.</p>
            </div>
        
        @elseif(!$attendance)
            <!-- State: Belum Absen -->
            <button onclick="openCamera('in')" class="group w-full relative overflow-hidden bg-[#D61600] rounded-3xl p-8 shadow-lg shadow-red-200 transition-all hover:shadow-xl hover:scale-[1.01] active:scale-95">
                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-black/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col items-center gap-4 text-white">
                    <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm border border-white/10 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold tracking-tight">CLOCK IN</h3>
                        <p class="text-red-100 text-sm mt-1">Absen Masuk</p>
                    </div>
                </div>
            </button>

        @elseif($attendance->jam_masuk && !$attendance->jam_keluar)
            <!-- State: Sudah Absen Masuk, Belum Keluar -->
            <button onclick="openCamera('out')" class="group w-full relative overflow-hidden bg-white border-2 border-[#D61600] rounded-3xl p-8 shadow-sm transition-all hover:shadow-md hover:bg-red-50 active:scale-95">
                <div class="relative z-10 flex flex-col items-center gap-4">
                    <div class="p-4 bg-red-100 rounded-2xl text-[#D61600] group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-[#D61600] tracking-tight">CLOCK OUT</h3>
                        <p class="text-gray-500 text-sm mt-1">Absen Pulang</p>
                    </div>
                </div>
            </button>

        @else
            <!-- State: Sudah Selesai -->
            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white shadow-sm rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#D61600]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Selesai</h2>
                <p class="text-gray-500 mt-2 text-sm">Terima kasih atas kerja keras Anda hari ini!</p>
            </div>
        @endif
    </div>

    <!-- Location Info -->
    <div class="flex justify-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-full border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <span class="text-xs text-gray-500 font-medium">Lat: {{ $settings['office_lat'] ?? '-' }} • Lng: {{ $settings['office_lng'] ?? '-' }}</span>
        </div>
    </div>
</div>

<!-- Fullscreen Camera Modal -->
<div id="camera-modal" class="fixed inset-0 bg-black z-[60] hidden flex flex-col">
    <!-- Camera Header -->
    <div class="absolute top-0 left-0 right-0 p-6 flex justify-between items-center z-10 bg-gradient-to-b from-black/80 to-transparent">
        <button onclick="closeCamera()" class="text-white p-2 hover:bg-white/10 rounded-full transition backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="text-white font-bold text-lg tracking-wide" id="modal-title">Ambil Foto</div>
        <button onclick="switchCamera()" class="text-white p-2 hover:bg-white/10 rounded-full transition backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
        </button>
    </div>

    <!-- Video Feed -->
    <div class="flex-1 relative bg-black flex items-center justify-center overflow-hidden">
        <video id="video-feed" autoplay playsinline class="w-full h-full object-cover"></video>
        <canvas id="canvas-process" class="hidden"></canvas>
        <img id="photo-preview" class="hidden w-full h-full object-cover absolute inset-0 z-20">
        
        <!-- Loading Overlay -->
        <div id="loading-overlay" class="absolute inset-0 z-30 bg-black/60 backdrop-blur-sm flex flex-col items-center justify-center hidden">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-[#D61600] border-t-transparent mb-4"></div>
            <div class="text-white font-medium tracking-wide">Memproses Lokasi...</div>
        </div>
    </div>

    <!-- Camera Controls -->
    <div class="bg-black p-8 pb-12 flex flex-col items-center gap-6">
        <!-- Capture Button -->
        <button id="btn-capture" onclick="takeSnapshot()" class="w-20 h-20 rounded-full border-4 border-white flex items-center justify-center active:scale-95 transition-all hover:bg-white/10">
            <div class="w-16 h-16 bg-[#D61600] rounded-full pointer-events-none"></div>
        </button>

        <!-- Preview Actions (Hidden by default) -->
        <div id="preview-actions" class="hidden w-full flex flex-col gap-4 max-w-sm">
            <div class="flex items-center justify-center gap-2 text-green-400 text-sm py-2 px-4 rounded-xl bg-green-500/10 border border-green-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Lokasi & Waktu terkunci
            </div>
            
            <form id="attendance-form" method="POST" enctype="multipart/form-data" class="w-full">
                @csrf
                <input type="hidden" name="lat" id="form-lat">
                <input type="hidden" name="lng" id="form-lng">
                <input type="file" name="photo" id="form-file" class="hidden"> 
                
                <button type="submit" class="w-full bg-[#D61600] text-white font-bold py-4 rounded-2xl text-lg shadow-lg shadow-red-900/20 active:bg-red-700 hover:bg-red-600 transition flex items-center justify-center gap-2">
                    <span>Kirim Absensi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>

            <button onclick="resetCamera()" class="text-gray-400 py-2 font-medium hover:text-white transition text-sm">Ambil Ulang Foto</button>
        </div>
    </div>
</div>

<script>
    let currentStream = null;
    let facingMode = 'user';
    let currentType = 'in'; // 'in' or 'out'

    function openCamera(type) {
        currentType = type;
        document.getElementById('modal-title').innerText = type === 'in' ? 'Absen Masuk' : 'Absen Pulang';
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
        const video = document.getElementById('video-feed');
        const canvas = document.getElementById('canvas-process');
        const photoPreview = document.getElementById('photo-preview');
        
        // Set canvas size to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        const ctx = canvas.getContext('2d');
        if (facingMode === 'user') {
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
        }
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Show preview
        photoPreview.src = canvas.toDataURL('image/jpeg');
        photoPreview.classList.remove('hidden');
        
        // Hide capture button, show processing
        document.getElementById('btn-capture').classList.add('hidden');
        document.getElementById('loading-overlay').classList.remove('hidden');
        
        // Get Location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Success
                    document.getElementById('form-lat').value = position.coords.latitude;
                    document.getElementById('form-lng').value = position.coords.longitude;
                    
                    // Convert canvas to file
                    canvas.toBlob((blob) => {
                        const file = new File([blob], "attendance_photo.jpg", { type: "image/jpeg" });
                        const container = new DataTransfer();
                        container.items.add(file);
                        document.getElementById('form-file').files = container.files;
                        
                        // Show actions
                        document.getElementById('loading-overlay').classList.add('hidden');
                        document.getElementById('preview-actions').classList.remove('hidden');
                    }, 'image/jpeg', 0.8);
                },
                (error) => {
                    alert("Gagal mendapatkan lokasi. Pastikan GPS aktif.");
                    resetCamera();
                },
                { enableHighAccuracy: true }
            );
        } else {
            alert("Browser tidak mendukung geolokasi.");
            resetCamera();
        }
    }

    function resetCamera() {
        document.getElementById('photo-preview').classList.add('hidden');
        document.getElementById('btn-capture').classList.remove('hidden');
        document.getElementById('preview-actions').classList.add('hidden');
        document.getElementById('loading-overlay').classList.add('hidden');
    }
</script>
@endsection
