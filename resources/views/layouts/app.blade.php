<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Sistem Absensi</title>
    <link rel="icon" href="{{ asset('logo_pt_mutiara.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Mobile-friendly touch targets */
        button, a { touch-action: manipulation; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 min-h-screen {{ request()->routeIs('login') ? '' : 'pt-16 pb-20 md:pb-0' }}">
    <!-- Header -->
    @unless(request()->routeIs('login'))
    <header class="bg-white border-b fixed top-0 left-0 right-0 z-50 shadow-sm">
        <div class="w-full px-4 sm:px-6 md:px-8 lg:px-12 h-16 flex items-center justify-between">
            <div class="font-bold text-lg md:text-xl tracking-tight text-[#D61600]">
            <a href="{{ url('/') }}" class="flex items-center gap-2 md:gap-3">
                <img src="{{ asset('logo_pt_mutiara.png') }}" alt="Logo" class="h-8 md:h-10 w-auto">
                <span class="whitespace-nowrap">PT Mutiara Jaya Express</span>
            </a>
        </div>

            <div class="flex items-center gap-6">
                <!-- Mobile Logout Button -->
                <div class="md:hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-[#D61600] transition-colors p-2" onclick="return confirm('Yakin ingin keluar?')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6 h-16">
                    @auth
                        @unless(request()->routeIs('admin.dashboard') || request()->routeIs('karyawan.dashboard'))
                            @if((auth()->user()->role ?? '') === 'admin')
                                <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                
                                @php
                                    $isKelolaActive = request()->routeIs('admin.karyawan.*') ||
                                                      request()->routeIs('admin.positions.*') ||
                                                      request()->routeIs('admin.shifts.*') ||
                                                      request()->routeIs('admin.attendance.*') ||
                                                      request()->routeIs('admin.leave.*') ||
                                                      request()->routeIs('admin.reports.*') ||
                                                      request()->routeIs('admin.settings.*');
                                @endphp
                                
                                <div id="kelolaWrapper" class="relative h-full flex items-center group">
                                    <button id="kelolaBtn" class="flex items-center gap-1 h-full border-b-2 text-sm font-bold px-1 border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300">
                                        Kelola
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div id="kelolaMenu" class="absolute top-full left-1/2 -translate-x-1/2 -translate-x-[10px] mt-1 min-w-[120px] bg-white shadow-lg rounded-md border border-gray-100 hidden py-1 z-[100]">
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.karyawan.index') }}">Karyawan</a>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.positions.index') }}">Posisi</a>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.shifts.index') }}">Shift</a>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.attendance.monitor') }}">Monitor</a>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.leave.index') }}">Izin</a>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.reports.index') }}">Laporan</a>
                                        <div class="border-t my-1"></div>
                                        <a class="block px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D61600]" href="{{ route('admin.settings.edit') }}">Settings</a>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full">
                                    @csrf
                                    <button type="submit" class="flex items-center h-full border-b-2 border-transparent text-sm font-bold px-1 text-gray-500 hover:text-[#D61600] hover:border-gray-300" onclick="return confirm('Yakin ingin keluar?')">Keluar</button>
                                </form>
                            @else
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.dashboard') }}">Beranda</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.attendance.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.attendance.index') }}">Absensi</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.leave.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.leave.index') }}">Izin</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.profile.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.profile.edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full ml-2">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center h-10 w-10 rounded-full text-gray-500 hover:text-[#D61600] hover:bg-red-50 transition-colors" title="Keluar" onclick="return confirm('Yakin ingin keluar?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <!-- Show only logout on dashboard for desktop if needed, or nothing -->
                             <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full">
                                @csrf
                                <button type="submit" class="flex items-center h-full border-b-2 border-transparent text-sm font-bold px-1 text-gray-500 hover:text-[#D61600] hover:border-gray-300" onclick="return confirm('Yakin ingin keluar?')">Keluar</button>
                            </form>
                        @endunless
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
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center p-2 text-gray-500">
                    @csrf
                    <button type="submit" class="flex flex-col items-center w-full" onclick="return confirm('Yakin ingin keluar?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="text-[10px] font-medium mt-1">Keluar</span>
                    </button>
                </form>
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
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center p-2 text-gray-500">
                    @csrf
                    <button type="submit" class="flex flex-col items-center w-full" onclick="return confirm('Yakin ingin keluar?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="text-[10px] font-medium mt-1">Keluar</span>
                    </button>
                </form>
            @endif
        </div>
    </nav>


    @endauth

    <main class="{{ request()->routeIs('login') ? 'w-full' : 'max-w-7xl mx-auto px-4 sm:px-6 md:px-8 lg:px-12 py-6 md:py-10' }}">
        @if (session('status'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Keluar Akun?',
                        text: "Apakah Anda yakin ingin keluar dari akun?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#D61600',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Keluar',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelolaWrapper = document.getElementById('kelolaWrapper');
            const kelolaBtn = document.getElementById('kelolaBtn');
            const kelolaMenu = document.getElementById('kelolaMenu');
            
            if (kelolaWrapper && kelolaBtn && kelolaMenu) {
                kelolaWrapper.addEventListener('mouseenter', function() {
                    kelolaMenu.classList.remove('hidden');
                });

                kelolaWrapper.addEventListener('mouseleave', function() {
                    kelolaMenu.classList.add('hidden');
                });

                kelolaBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            }
        });
    </script>
</body>
</html>
