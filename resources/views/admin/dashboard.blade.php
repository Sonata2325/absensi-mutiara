@extends('layouts.app')

@section('content')
<!-- Skeleton Loader to prevent CLS -->
<div id="skeletonLoader">
    <style>
        .skeleton-loader { width: 100%; padding: 20px; }
        .skeleton-header { height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 8px; margin-bottom: 24px; width: 300px; }
        .skeleton-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .skeleton-card-sm { height: 100px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 16px; }
        .skeleton-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .skeleton-card-lg { height: 120px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 16px; }
        .skeleton-chart { height: 350px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 16px; }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    </style>
    <div class="skeleton-loader">
        <div class="skeleton-header"></div>
        <div class="skeleton-grid">
            <div class="skeleton-card-sm"></div>
            <div class="skeleton-card-sm"></div>
            <div class="skeleton-card-sm"></div>
            <div class="skeleton-card-sm"></div>
            <div class="skeleton-card-sm"></div>
            <div class="skeleton-card-sm"></div>
        </div>
        <div class="skeleton-stats">
            <div class="skeleton-card-lg"></div>
            <div class="skeleton-card-lg"></div>
            <div class="skeleton-card-lg"></div>
            <div class="skeleton-card-lg"></div>
        </div>
        <div class="skeleton-chart"></div>
    </div>
</div>

<div id="dashboardContent" style="display: none;">
<div class="flex flex-col gap-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Ringkasan kehadiran dan aktivitas terbaru</p>
        </div>
        <div class="flex items-center gap-2 text-gray-600 bg-gray-50 px-4 py-2 rounded-xl border border-gray-200/60">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium text-sm">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
        <a href="{{ route('admin.attendance.monitor') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-blue-50/50 rounded-xl flex items-center justify-center text-blue-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Monitor</h3>
        </a>

        <a href="{{ route('admin.karyawan.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-green-50/50 rounded-xl flex items-center justify-center text-green-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Karyawan</h3>
        </a>

        <a href="{{ route('admin.leave.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-purple-50/50 rounded-xl flex items-center justify-center text-purple-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Izin / Cuti</h3>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-red-50/50 rounded-xl flex items-center justify-center text-red-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Laporan</h3>
        </a>

        <a href="{{ route('admin.positions.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-yellow-50/50 rounded-xl flex items-center justify-center text-yellow-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Posisi</h3>
        </a>

        <a href="{{ route('admin.shifts.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-indigo-50/50 rounded-xl flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Shift</h3>
        </a>

        <a href="{{ route('admin.settings.edit') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-gray-50/50 rounded-xl flex items-center justify-center text-gray-600 mb-3 group-hover:scale-105 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 text-sm md:text-base text-center">Settings</h3>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-blue-50/50 rounded-xl text-blue-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Total Karyawan</div>
                    <div class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $totalEmployees }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-green-50/50 rounded-xl text-green-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Hadir Hari Ini</div>
                    <div class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $hadirHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-yellow-50/50 rounded-xl text-yellow-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Terlambat</div>
                    <div class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $terlambatHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-orange-50/50 rounded-xl text-orange-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Izin Menunggu</div>
                    <div class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $pendingLeaves ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-purple-50/50 rounded-xl text-purple-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Izin / Cuti Hari Ini</div>
                    <div class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $izinHariIni }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 tracking-tight">Ringkasan Izin Hari Ini</h2>
                <p class="text-sm text-gray-500">Pantau karyawan yang sedang izin</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.attendance.monitor') }}" class="px-3 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition">Monitor</a>
                <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition">Laporan</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50/50 text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3 font-medium">Karyawan</th>
                        <th class="px-5 py-3 font-medium">Posisi</th>
                        <th class="px-5 py-3 font-medium">Jenis Izin</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Sisa Cuti Tahunan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($leaveSummary as $leave)
                        <tr class="hover:bg-gray-50/50 transition cursor-pointer" onclick="window.location='{{ route('admin.karyawan.show', $leave['employee']->id) }}'">
                            <td class="px-5 py-3 font-medium text-gray-900">{{ $leave['employee']?->name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $leave['employee']?->position?->nama_posisi ?? '-' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ ucwords(str_replace('_', ' ', $leave['type'])) }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $leave['start'] }} - {{ $leave['end'] }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $leave['remaining_annual'] }} hari</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="text-sm">Tidak ada karyawan yang izin hari ini</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 tracking-tight">Grafik Kehadiran Bulanan</h2>
                <p class="text-sm text-gray-500">Geser untuk melihat riwayat</p>
            </div>
            <a href="{{ route('admin.attendance.monitor') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline font-medium">Lihat Detail</a>
        </div>
        
        <!-- Horizontal Scroll Container for Chart -->
        <div class="overflow-x-auto pb-4 custom-scrollbar">
            <div class="min-w-[800px] h-[350px]">
                <div id="attendanceChart"></div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Script to handle Skeleton Loader -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to switch view
        function hideSkeleton() {
            const skeleton = document.getElementById('skeletonLoader');
            const content = document.getElementById('dashboardContent');
            
            if (skeleton && content && skeleton.style.display !== 'none') {
                skeleton.style.display = 'none';
                content.style.display = 'block';
                
                // Trigger chart resize to ensure it renders correctly after being hidden
                window.dispatchEvent(new Event('resize'));
            }
        }

        // Show content when fully loaded
        window.addEventListener('load', hideSkeleton);
        
        // Fallback: Force show content after 2 seconds max (in case of hanging resources)
        setTimeout(hideSkeleton, 2000);
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chart);
        
        const options = {
            series: [{
                name: 'Hadir',
                data: chartData.map(item => item.hadir)
            }, {
                name: 'Terlambat',
                data: chartData.map(item => item.terlambat)
            }, {
                name: 'Alpha',
                data: chartData.map(item => item.alpha)
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: chartData.map(item => item.tanggal),
                labels: {
                    formatter: function (value) {
                        const date = new Date(value);
                        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                    },
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Karyawan'
                },
                labels: {
                    formatter: function (value) {
                        return value.toFixed(0);
                    }
                },
                forceNiceScale: true,
                min: 0,
                decimalsInFloat: 0
            },
            fill: {
                opacity: 1
            },
            colors: ['#10B981', '#F59E0B', '#EF4444'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " orang"
                    }
                }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right', 
                offsetY: -20
            }
        };

        const chart = new ApexCharts(document.querySelector("#attendanceChart"), options);
        chart.render();

        // Auto scroll to end (latest date)
        const container = document.querySelector('.custom-scrollbar');
        if(container) {
            container.scrollLeft = container.scrollWidth;
        }
    });
</script>
