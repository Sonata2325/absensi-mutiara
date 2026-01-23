@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('karyawan.leave.index') }}" class="p-2 rounded-xl hover:bg-gray-100 transition text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ajukan Izin</h1>
            <p class="text-gray-500 text-sm">Isi form di bawah untuk mengajukan permohonan</p>
        </div>
    </div>

    <!-- Form Card -->
    <form method="POST" action="{{ route('karyawan.leave.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden">
        @csrf
        
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-50 pointer-events-none"></div>

        <div class="space-y-6 relative z-10">
            <!-- Tipe & Dokumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Jenis Pengajuan</label>
                    <div class="relative">
                        <select id="tipe-select" name="tipe" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 appearance-none cursor-pointer transition-colors hover:bg-gray-100 hover:border-[#D61600]" required onchange="updateDokumenLabel()">
                            <option value="sakit" @selected(old('tipe') === 'sakit')>Sakit</option>
                            <option value="cuti_tahunan" @selected(old('tipe') === 'cuti_tahunan')>Cuti Tahunan</option>
                            <option value="melahirkan" @selected(old('tipe') === 'melahirkan')>Melahirkan</option>
                            <option value="menikah" @selected(old('tipe') === 'menikah')>Menikah</option>
                            <option value="duka_keluarga_inti" @selected(old('tipe') === 'duka_keluarga_inti')>Duka Keluarga Inti</option>
                            <option value="duka_bukan_keluarga_inti" @selected(old('tipe') === 'duka_bukan_keluarga_inti')>Duka Bukan Keluarga Inti</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    @error('tipe')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-2">
                    <label id="dokumen-label" class="text-sm font-semibold text-gray-700 ml-1">Dokumen (Opsional)</label>
                    <label class="flex items-center gap-3 w-full p-3 bg-gray-50 border border-gray-200 border-dashed rounded-xl cursor-pointer hover:bg-gray-100 hover:border-[#D61600] transition-all group">
                        <div class="p-2 bg-white rounded-lg shadow-sm text-gray-400 group-hover:text-[#D61600]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 truncate group-hover:text-gray-700">Klik untuk upload file</p>
                        </div>
                        <input type="file" name="dokumen_pendukung" class="hidden" onchange="this.previousElementSibling.firstElementChild.innerText = this.files[0] ? this.files[0].name : 'Klik untuk upload file'">
                    </label>
                    @error('dokumen_pendukung')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Mulai Tanggal</label>
                    <input name="tanggal_mulai" id="tanggal_mulai" type="date" value="{{ old('tanggal_mulai') }}" min="{{ now()->toDateString() }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required onchange="updateTanggalSelesaiMin()">
                    @error('tanggal_mulai')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Sampai Tanggal</label>
                    <input name="tanggal_selesai" id="tanggal_selesai" type="date" value="{{ old('tanggal_selesai') }}" min="{{ now()->toDateString() }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                    @error('tanggal_selesai')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Alasan -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 ml-1">Alasan Pengajuan</label>
                <textarea name="alasan" rows="4" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600] resize-none" placeholder="Jelaskan alasan anda..." required>{{ old('alasan') }}</textarea>
                @error('alasan')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
            </div>

            <!-- Tanda Tangan -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 ml-1">Tanda Tangan</label>
                <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 flex flex-col items-center justify-center">
                    <canvas id="signature-pad" class="border border-gray-300 rounded-lg bg-white w-full max-w-[400px] h-[200px] touch-none"></canvas>
                    <input type="hidden" name="signature" id="signature-input">
                    <div class="flex gap-2 mt-3">
                        <button type="button" id="clear-signature" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Hapus</button>
                    </div>
                </div>
                @error('signature')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 flex items-center gap-4">
                <button type="submit" class="flex-1 bg-[#D61600] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-red-200 hover:shadow-xl hover:bg-[#b01200] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <span>Kirim Pengajuan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function updateDokumenLabel() {
        const tipe = document.getElementById('tipe-select').value;
        const label = document.getElementById('dokumen-label');
        
        if (tipe === 'sakit' || tipe === 'menikah') {
            label.innerText = 'Dokumen (Wajib)';
        } else {
            label.innerText = 'Dokumen (Opsional)';
        }
    }

    function updateTanggalSelesaiMin() {
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        
        if (tanggalMulai.value) {
            tanggalSelesai.min = tanggalMulai.value;
            
            // Jika tanggal selesai yang dipilih sebelumnya lebih kecil dari tanggal mulai baru, reset
            if (tanggalSelesai.value && tanggalSelesai.value < tanggalMulai.value) {
                tanggalSelesai.value = tanggalMulai.value;
            }
        } else {
            // Default min hari ini jika tanggal mulai kosong
            tanggalSelesai.min = "{{ now()->toDateString() }}";
        }
    }
    
    // Signature Pad Logic
    document.addEventListener('DOMContentLoaded', function() {
        updateDokumenLabel();
        updateTanggalSelesaiMin();

        const canvas = document.getElementById('signature-pad');
        const signatureInput = document.getElementById('signature-input');
        const clearButton = document.getElementById('clear-signature');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;

        // Resize canvas to fit container
        function resizeCanvas() {
            // Set canvas size to display size
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            
            // Set stroke style
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
        }
        
        // Initial resize
        resizeCanvas();
        // Resize on window resize
        window.addEventListener('resize', resizeCanvas);

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function startDraw(e) {
            isDrawing = true;
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            // Prevent default behavior for touch events to avoid scrolling
            if(e.type === 'touchstart') e.preventDefault();
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            if(e.type === 'touchmove') e.preventDefault();
        }

        function stopDraw() {
            if (isDrawing) {
                isDrawing = false;
                signatureInput.value = canvas.toDataURL();
            }
        }

        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDraw);
        canvas.addEventListener('mouseout', stopDraw);

        canvas.addEventListener('touchstart', startDraw, {passive: false});
        canvas.addEventListener('touchmove', draw, {passive: false});
        canvas.addEventListener('touchend', stopDraw);

        clearButton.addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            signatureInput.value = '';
        });
    });
</script>
@endsection
