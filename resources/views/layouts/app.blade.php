<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Sistem Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Mobile-friendly touch targets */
        button, a { touch-action: manipulation; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 min-h-screen {{ request()->routeIs('login') ? '' : 'pb-20 md:pb-0' }}">
    <!-- Header -->
    @unless(request()->routeIs('login'))
    <header class="bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="w-full px-4 h-16 flex items-center justify-between">
            <div class="font-bold text-xl tracking-tight text-[#D61600]">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('LOGO PT.Mutiara.jpeg') }}" alt="Logo" class="h-10 w-auto">
                    <span>PT Mutiara Jaya Express</span>
                </a>
            </div>

            <div class="flex items-center gap-6">
                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6 h-16">
                    @auth
                        @if((auth()->user()->role ?? '') === 'admin')
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.karyawan.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.karyawan.index') }}">Karyawan</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.departments.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.departments.index') }}">Department</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.shifts.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.shifts.index') }}">Shift</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.attendance.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.attendance.monitor') }}">Monitor</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.leave.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.leave.index') }}">Izin</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.reports.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.reports.index') }}">Laporan</a>
                            <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.settings.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.settings.edit') }}">Settings</a>
                        @else
                            <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.dashboard') }}">Beranda</a>
                            <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.attendance.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.attendance.index') }}">Absensi</a>
                            <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.leave.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.leave.index') }}">Izin</a>
                            <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.profile.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.profile.edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>
    @endunless

    @auth
    <!-- Mobile Bottom Nav -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t z-40 pb-safe">
        <div class="flex justify-around items-center h-16 px-2">
            @if((auth()->user()->role ?? '') === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="text-[10px] font-medium mt-1">Dash</span>
                </a>
                <a href="{{ route('admin.attendance.monitor') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.attendance.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Absen</span>
                </a>
                <a href="{{ route('admin.karyawan.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.karyawan.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span class="text-[10px] font-medium mt-1">Staff</span>
                </a>
                <a href="{{ route('admin.leave.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.leave.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Izin</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.settings.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span class="text-[10px] font-medium mt-1">Set</span>
                </a>
            @else
                <a href="{{ route('karyawan.dashboard') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="text-[10px] font-medium mt-1">Home</span>
                </a>
                <a href="{{ route('karyawan.attendance.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.attendance.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 12h-6.75"></path><path d="M17.25 17.25 23 12l-5.75-5.25"></path><path d="M10 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle></svg>
                    <span class="text-[10px] font-medium mt-1">Absen</span>
                </a>
                <a href="{{ route('karyawan.leave.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.leave.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Izin</span>
                </a>
                <a href="{{ route('karyawan.profile.edit') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.profile.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span class="text-[10px] font-medium mt-1">Profil</span>
                </a>
            @endif
        </div>
    </nav>


    @endauth

    <main class="{{ request()->routeIs('login') ? 'w-full' : 'max-w-6xl mx-auto px-4 py-6 md:py-8' }}">
        @if (session('status'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
