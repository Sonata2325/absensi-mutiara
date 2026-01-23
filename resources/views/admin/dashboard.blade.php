@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Ringkasan kehadiran dan aktivitas terbaru</p>
        </div>
        <div class="flex items-center gap-2 text-gray-600 bg-white px-4 py-2 rounded-lg border border-gray-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
        <a href="{{ route('admin.attendance.monitor') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-100 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Monitor</h3>
        </a>

        <a href="{{ route('admin.karyawan.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-100 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Karyawan</h3>
        </a>

        <a href="{{ route('admin.leave.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-100 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Izin / Cuti</h3>
        </a>

        <a href="{{ route('admin.departments.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-100 transition group hover:-translate-y-0.5">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Laporan</h3>
        </a>

        <a href="{{ route('admin.shifts.index') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Shift</h3>
        </a>

        <a href="{{ route('admin.settings.edit') }}" class="bg-white p-4 md:p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-100 transition group">
            <div class="w-10 h-10 md:w-12 md:h-12 mx-auto bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 mb-3 group-hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 text-sm md:text-base text-center">Settings</h3>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Total Karyawan</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $totalEmployees }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-green-50 rounded-xl text-green-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Hadir Hari Ini</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $hadirHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Terlambat</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $terlambatHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600 w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Izin / Cuti</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $izinHariIni }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Grafik Kehadiran Bulanan</h2>
                <p class="text-sm text-gray-500">Geser untuk melihat riwayat</p>
            </div>
            <a href="{{ route('admin.attendance.monitor') }}" class="text-sm text-blue-600 hover:underline">Lihat Detail</a>
        </div>
        
        <!-- Horizontal Scroll Container for Chart -->
        <div class="overflow-x-auto pb-4 custom-scrollbar">
            <div class="min-w-[800px] h-[350px]">
                <div id="attendanceChart"></div>
            </div>
        </div>
    </div>
</div>

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
                    borderRadius: 4,
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
                }
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
