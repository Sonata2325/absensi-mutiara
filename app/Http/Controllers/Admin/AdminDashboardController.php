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
                DB::raw('date(tanggal) as tanggal'),
                DB::raw("sum(case when status = 'hadir' then 1 else 0 end) as hadir"),
                DB::raw("sum(case when status = 'terlambat' then 1 else 0 end) as terlambat"),
            ])
            ->whereBetween('tanggal', [$monthStartDt, $monthEndDt])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy(fn ($row) => (string) $row->tanggal);

        $period = CarbonPeriod::create(Carbon::parse($monthStart), Carbon::parse($monthEnd));
        $chart = [];
        foreach ($period as $date) {
            $key = $date->toDateString();
            $row = $attendanceByDay->get($key);
            $chart[] = [
                'tanggal' => $key,
                'hadir' => (int) ($row?->hadir ?? 0),
                'terlambat' => (int) ($row?->terlambat ?? 0),
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
