@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Profile Card Section -->
    <div class="bg-[#D61600] rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-2xl -ml-12 -mb-12 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
                @if(auth()->user()->foto_profile)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile" class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-white/30 shadow-md">
                @else
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                @endif
            </div>

            <!-- Profile Info -->
            <div class="text-center md:text-left flex-1">
                <h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wide leading-tight mb-2">{{ auth()->user()->name }}</h2>
                <div class="space-y-1 text-red-50 text-sm md:text-base font-medium">
                    <p class="text-white/90">{{ auth()->user()->phone }}</p>
                    <p class="uppercase opacity-90">Status: Aktif</p>
                    @if(auth()->user()->position)
                        <p class="uppercase opacity-90">{{ auth()->user()->position->nama_posisi }}</p>
                    @else
                         <p class="uppercase opacity-90">KARYAWAN</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Status Kehadiran Section -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Status Kehadiran</p>
                @if(isset($attendanceToday) && $attendanceToday->jam_masuk)
                    <h3 class="text-2xl font-bold text-gray-800">Hadir</h3>
                    <p class="text-xs text-gray-400 mt-1">Masuk: {{ \Carbon\Carbon::parse($attendanceToday->jam_masuk)->format('H:i') }}</p>
                @else
                    <h3 class="text-2xl font-bold text-gray-800">Belum Hadir</h3>
                    <p class="text-xs text-gray-400 mt-1">Silahkan melakukan absensi</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-full {{ isset($attendanceToday) && $attendanceToday->jam_masuk ? 'bg-green-100 text-green-600' : 'bg-red-100 text-[#D61600]' }} flex items-center justify-center">
                @if(isset($attendanceToday) && $attendanceToday->jam_masuk)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                @endif
            </div>
        </div>
    </div>

    <!-- Menu Grid Section -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-wrap justify-evenly w-full">
            
            <!-- Absensi -->
            <a href="{{ route('karyawan.attendance.index') }}" class="group flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-700 group-hover:bg-red-50 group-hover:text-[#D61600] transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <span class="text-sm font-semibold text-gray-700 group-hover:text-[#D61600] transition-colors">Absensi</span>
            </a>

            <!-- Izin -->
            <a href="{{ route('karyawan.leave.index') }}" class="group flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-700 group-hover:bg-red-50 group-hover:text-[#D61600] transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <span class="text-sm font-semibold text-gray-700 group-hover:text-[#D61600] transition-colors">Izin</span>
            </a>

            <!-- Jadwal / Riwayat -->
            <a href="{{ route('karyawan.attendance.history') }}" class="group flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-700 group-hover:bg-red-50 group-hover:text-[#D61600] transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <span class="text-sm font-semibold text-gray-700 group-hover:text-[#D61600] transition-colors">Riwayat</span>
            </a>



        </div>
    </div>
</div>
@endsection
