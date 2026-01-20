<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalEmployees = User::query()->where('role', 'employee')->count();
        $hadirHariIni = Attendance::query()
            ->whereDate('tanggal', $today)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();

        $terlambatHariIni = Attendance::query()
            ->whereDate('tanggal', $today)
            ->where('status', 'terlambat')
            ->count();

        $izinHariIni = LeaveRequest::query()
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->count();

        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();
        $monthStartDt = now()->startOfMonth()->startOfDay()->toDateTimeString();
        $monthEndDt = now()->endOfMonth()->endOfDay()->toDateTimeString();

        $attendanceByDay = Attendance::query()
            ->select([
                DB::raw('DATE(tanggal) as date_only'),
                DB::raw("sum(case when status = 'hadir' then 1 else 0 end) as hadir"),
                DB::raw("sum(case when status = 'terlambat' then 1 else 0 end) as terlambat"),
                DB::raw("sum(case when status = 'alpha' then 1 else 0 end) as alpha"),
            ])
            ->whereBetween('tanggal', [$monthStartDt, $monthEndDt])
            ->groupBy('date_only')
            ->orderBy('date_only')
            ->get()
            ->keyBy('date_only');

        $period = CarbonPeriod::create(Carbon::parse($monthStart), Carbon::parse($monthEnd));
        $chart = [];
        foreach ($period as $date) {
            $key = $date->toDateString();
            $row = $attendanceByDay->get($key);
            $chart[] = [
                'tanggal' => $key,
                'hadir' => (int) ($row?->hadir ?? 0),
                'terlambat' => (int) ($row?->terlambat ?? 0),
                'alpha' => (int) ($row?->alpha ?? 0),
            ];
        }

        return view('admin.dashboard', [
            'totalEmployees' => $totalEmployees,
            'hadirHariIni' => $hadirHariIni,
            'izinHariIni' => $izinHariIni,
            'terlambatHariIni' => $terlambatHariIni,
            'chart' => $chart,
        ]);
    }
}
