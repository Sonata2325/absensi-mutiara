<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $attendanceToday = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $leaveToday = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();

        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();
        $monthStartDt = now()->startOfMonth()->startOfDay()->toDateTimeString();
        $monthEndDt = now()->endOfMonth()->endOfDay()->toDateTimeString();

        $summary = Attendance::query()
            ->select([
                DB::raw("sum(case when status = 'hadir' then 1 else 0 end) as hadir"),
                DB::raw("sum(case when status = 'terlambat' then 1 else 0 end) as terlambat"),
                DB::raw("sum(case when status = 'alpha' then 1 else 0 end) as alpha"),
            ])
            ->where('employee_id', $user->id)
            ->whereBetween('tanggal', [$monthStartDt, $monthEndDt])
            ->first();

        $usedLeaveThisYear = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('status', 'approved')
            ->whereYear('tanggal_mulai', now()->year)
            ->count();

        return view('karyawan.dashboard', [
            'attendanceToday' => $attendanceToday,
            'leaveToday' => $leaveToday,
            'summary' => $summary,
            'usedLeaveThisYear' => $usedLeaveThisYear,
        ]);
    }
}
