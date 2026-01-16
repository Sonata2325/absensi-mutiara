<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $startDt = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay()->toDateTimeString();
        $endDt = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()->toDateTimeString();

        $attendances = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.department', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        return view('admin.reports.index', [
            'month' => $month,
            'year' => $year,
            'start' => $start,
            'end' => $end,
            'attendances' => $attendances,
        ]);
    }

    public function attendanceCsv(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $startDt = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay()->toDateTimeString();
        $endDt = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()->toDateTimeString();

        $rows = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.department', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        $filename = "laporan-absensi-{$year}-".str_pad((string) $month, 2, '0', STR_PAD_LEFT).'.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Tanggal', 'NIP', 'Nama', 'Department', 'Shift', 'Jam Masuk', 'Jam Keluar', 'Status', 'Keterangan']);
        foreach ($rows as $row) {
            fputcsv($handle, [
                (string) $row->tanggal?->toDateString(),
                (string) ($row->employee?->nip ?? ''),
                (string) ($row->employee?->name ?? ''),
                (string) ($row->employee?->department?->nama_department ?? ''),
                (string) ($row->employee?->shift?->nama_shift ?? ''),
                (string) ($row->jam_masuk ?? ''),
                (string) ($row->jam_keluar ?? ''),
                (string) ($row->status ?? ''),
                (string) ($row->keterangan ?? ''),
            ]);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function attendancePdf(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $startDt = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay()->toDateTimeString();
        $endDt = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()->toDateTimeString();

        $attendances = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.department', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        return view('admin.reports.pdf', [
            'month' => $month,
            'year' => $year,
            'start' => $start,
            'end' => $end,
            'attendances' => $attendances,
        ]);
    }
}
