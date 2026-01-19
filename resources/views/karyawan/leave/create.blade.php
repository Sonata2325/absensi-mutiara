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
                        <select name="tipe" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 appearance-none cursor-pointer transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                            <option value="sakit" @selected(old('tipe') === 'sakit')>Sakit</option>
                            <option value="cuti" @selected(old('tipe') === 'cuti')>Cuti Tahunan</option>
                            <option value="izin" @selected(old('tipe') === 'izin')>Izin Lainnya</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    @error('tipe')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Dokumen (Opsional)</label>
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
                    <input name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                    @error('tanggal_mulai')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 ml-1">Sampai Tanggal</label>
                    <input name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600]" required>
                    @error('tanggal_selesai')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Alasan -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 ml-1">Alasan Pengajuan</label>
                <textarea name="alasan" rows="4" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-[#D61600] focus:border-[#D61600] block p-3.5 transition-colors hover:bg-gray-100 hover:border-[#D61600] resize-none" placeholder="Jelaskan alasan anda..." required>{{ old('alasan') }}</textarea>
                @error('alasan')<div class="text-xs text-red-500 font-medium ml-1">{{ $message }}</div>@enderror
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
@endsection
