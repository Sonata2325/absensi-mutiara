<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminAttendanceMonitorController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $employees = User::query()
            ->where('role', 'employee')
            ->with(['department', 'shift'])
            ->orderBy('name')
            ->get();

        $attendanceToday = Attendance::query()
            ->whereDate('tanggal', $today)
            ->get()
            ->keyBy('employee_id');

        $leaveToday = LeaveRequest::query()
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->get()
            ->keyBy('employee_id');

        $office = [
            'lat' => Setting::getValue('office_lat', ''),
            'lng' => Setting::getValue('office_lng', ''),
            'radius' => Setting::getValue('office_radius_meters', '200'),
        ];

        return view('admin.attendance.monitor', [
            'employees' => $employees,
            'attendanceToday' => $attendanceToday,
            'leaveToday' => $leaveToday,
            'today' => Carbon::parse($today),
            'office' => $office,
        ]);
    }
}
