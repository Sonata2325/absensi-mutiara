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
                <!-- Mobile Top Actions -->
                <div class="md:hidden flex items-center gap-1">
                    @if((auth()->user()->role ?? '') === 'admin')
                        <a href="{{ route('admin.settings.edit') }}" class="text-gray-500 hover:text-[#D61600] transition-colors p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </a>
                    @endif
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
                                <!-- Dashboard -->
                                <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                
                                <!-- Data Karyawan Dropdown -->
                                @php
                                    $isDataKaryawanActive = request()->routeIs('admin.karyawan.*') ||
                                                            request()->routeIs('admin.positions.*') ||
                                                            request()->routeIs('admin.shifts.*');
                                @endphp
                                <div id="nav-data-karyawan" class="relative h-full flex items-center group">
                                    <button class="flex items-center gap-1 h-full border-b-2 text-sm font-bold px-1 {{ $isDataKaryawanActive ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}">
                                        Data Karyawan
                                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div class="dropdown-menu absolute top-full left-0 mt-0 w-48 bg-white shadow-lg rounded-b-xl border-x border-b border-red-100 hidden group-hover:block z-[100]">
                                        <a class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#D61600] transition-colors first:rounded-t-none last:rounded-b-xl" href="{{ route('admin.karyawan.index') }}">Karyawan</a>
                                        <a class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#D61600] transition-colors" href="{{ route('admin.positions.index') }}">Posisi</a>
                                        <a class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#D61600] transition-colors last:rounded-b-xl" href="{{ route('admin.shifts.index') }}">Shift</a>
                                    </div>
                                </div>

                                <!-- Operasional Dropdown -->
                                @php
                                    $isOperasionalActive = request()->routeIs('admin.attendance.*') ||
                                                           request()->routeIs('admin.leave.*');
                                @endphp
                                <div id="nav-operasional" class="relative h-full flex items-center group">
                                    <button class="flex items-center gap-1 h-full border-b-2 text-sm font-bold px-1 {{ $isOperasionalActive ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}">
                                        Operasional
                                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div class="dropdown-menu absolute top-full left-0 mt-0 w-48 bg-white shadow-lg rounded-b-xl border-x border-b border-red-100 hidden group-hover:block z-[100]">
                                        <a class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#D61600] transition-colors first:rounded-t-none" href="{{ route('admin.attendance.monitor') }}">Monitor</a>
                                        <a class="block px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#D61600] transition-colors last:rounded-b-xl" href="{{ route('admin.leave.index') }}">Izin</a>
                                    </div>
                                </div>

                                <!-- Laporan -->
                                <a class="flex items-center h-full border-b-2 text-sm font-bold px-1 {{ request()->routeIs('admin.reports.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }}" href="{{ route('admin.reports.index') }}">Laporan</a>

                                <!-- Settings -->
                                <a href="{{ route('admin.settings.edit') }}" class="flex items-center h-full border-b-2 {{ request()->routeIs('admin.settings.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-gray-300' }} text-sm font-bold px-1 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Settings
                                </a>

                                <!-- Keluar -->
                                <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full">
                                    @csrf
                                    <button type="submit" class="flex items-center h-full border-b-2 border-transparent text-sm font-bold px-1 text-gray-500 hover:text-[#D61600] hover:border-gray-300" onclick="return confirm('Yakin ingin keluar?')">Keluar</button>
                                </form>
                            @else
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.dashboard') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.dashboard') }}">Beranda</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.attendance.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.attendance.index') }}">Absensi</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.leave.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.leave.index') }}">Izin</a>
                                <a class="flex items-center h-full border-b-2 text-lg font-semibold px-1 {{ request()->routeIs('karyawan.profile.*') ? 'border-[#D61600] text-[#D61600]' : 'border-transparent text-gray-500 hover:text-[#D61600] hover:border-[#D61600]' }}" href="{{ route('karyawan.profile.edit') }}">
                                    @if(auth()->user()->foto_profile)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    @endif
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full ml-2">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center h-10 w-10 rounded-full text-gray-500 hover:text-[#D61600] hover:bg-red-50 transition-colors" title="Keluar" onclick="return confirm('Yakin ingin keluar?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <!-- Show profile/settings and logout on dashboard -->
                            @if((auth()->user()->role ?? '') === 'admin')
                                <a href="{{ route('admin.settings.edit') }}" class="flex items-center h-full border-b-2 border-transparent text-sm font-bold px-1 text-gray-500 hover:text-[#D61600] hover:border-gray-300 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Settings
                                </a>
                            @else
                                <a href="{{ route('karyawan.profile.edit') }}" class="flex items-center h-full border-b-2 border-transparent text-sm font-bold px-1 text-gray-500 hover:text-[#D61600] hover:border-gray-300 mr-4">
                                    @if(auth()->user()->foto_profile)
                                        <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover mr-2 border border-gray-200">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                    Profile
                                </a>
                            @endif
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
                    <span class="text-[10px] font-medium mt-1">Monitor</span>
                </a>
                <a href="{{ route('admin.karyawan.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.karyawan.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span class="text-[10px] font-medium mt-1">Staff</span>
                </a>
                <a href="{{ route('admin.leave.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.leave.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Izin</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.reports.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 17H7A5 5 0 0 1 7 7h2"></path><path d="M15 7h2a5 5 0 1 1 0 10h-2"></path><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    <span class="text-[10px] font-medium mt-1">Laporan</span>
                </a>
                <a href="{{ route('admin.positions.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.positions.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Posisi</span>
                </a>
                <a href="{{ route('admin.shifts.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('admin.shifts.*') ? 'text-blue-600' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Shift</span>
                </a>
            @else
                <a href="{{ route('karyawan.dashboard') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.dashboard') ? 'text-[#D61600]' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="text-[10px] font-medium mt-1">Home</span>
                </a>
                <a href="{{ route('karyawan.attendance.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.attendance.*') ? 'text-[#D61600]' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 12h-6.75"></path><path d="M17.25 17.25 23 12l-5.75-5.25"></path><path d="M10 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle></svg>
                    <span class="text-[10px] font-medium mt-1">Absen</span>
                </a>
                <a href="{{ route('karyawan.leave.index') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.leave.*') ? 'text-[#D61600]' : 'text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span class="text-[10px] font-medium mt-1">Izin</span>
                </a>
                <a href="{{ route('karyawan.profile.edit') }}" class="flex flex-col items-center p-2 {{ request()->routeIs('karyawan.profile.*') ? 'text-[#D61600]' : 'text-gray-500' }}">
                    @if(auth()->user()->foto_profile)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Profile" class="w-6 h-6 rounded-full object-cover border border-gray-200">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Logic for Desktop
            const dropdowns = [
                { id: 'nav-data-karyawan' },
                { id: 'nav-operasional' }
            ];

            dropdowns.forEach(item => {
                const wrapper = document.getElementById(item.id);
                if (wrapper) {
                    const menu = wrapper.querySelector('.dropdown-menu');
                    const button = wrapper.querySelector('button');

                    if (menu && button) {
                        // Show on hover (mouseenter)
                        wrapper.addEventListener('mouseenter', () => {
                            menu.classList.remove('hidden');
                            // Close other dropdowns
                            dropdowns.forEach(otherItem => {
                                if (otherItem.id !== item.id) {
                                    const otherWrapper = document.getElementById(otherItem.id);
                                    const otherMenu = otherWrapper?.querySelector('.dropdown-menu');
                                    if (otherMenu) otherMenu.classList.add('hidden');
                                }
                            });
                        });

                        // Toggle on click
                        button.addEventListener('click', (e) => {
                            e.stopPropagation();
                            menu.classList.toggle('hidden');
                        });

                        // Close on mouse leave (reset state)
                        wrapper.addEventListener('mouseleave', () => {
                            menu.classList.add('hidden');
                        });

                        // Close when clicking outside
                        document.addEventListener('click', (e) => {
                            if (!wrapper.contains(e.target)) {
                                menu.classList.add('hidden');
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
