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
            ->with(['employee.position', 'employee.shift'])
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
            ->with(['employee.position', 'employee.shift'])
            ->with(['employee.leaveRequests' => function ($query) use ($start, $end) {
                $query->where('status', 'approved')
                      ->where(function ($q) use ($start, $end) {
                          $q->whereBetween('tanggal_mulai', [$start, $end])
                            ->orWhereBetween('tanggal_selesai', [$start, $end])
                            ->orWhere(function ($sub) use ($start, $end) {
                                $sub->where('tanggal_mulai', '<', $start)
                                    ->where('tanggal_selesai', '>', $end);
                            });
                      });
            }])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        $filename = "laporan-absensi-{$year}-".str_pad((string) $month, 2, '0', STR_PAD_LEFT).'.xls';
        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $html = '
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <style>
                body { font-family: Arial, sans-serif; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000000; padding: 8px; text-align: left; vertical-align: top; }
                th { background-color: #e0e0e0; font-weight: bold; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; text-align: center; }
                .info-table { margin-bottom: 20px; border: none; }
                .info-table td { border: none; padding: 5px; }
            </style>
        </head>
        <body>
            <div class="title">LAPORAN KEHADIRAN KARYAWAN</div>
            <table class="info-table">
                <tr>
                    <td style="width: 150px; font-weight: bold;">Periode</td>
                    <td>: ' . htmlspecialchars($monthName) . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Perusahaan</td>
                    <td>: PT Mutiara Jaya Express</td>
                </tr>
            </table>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Shift</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        <th>Overtime</th>
                        <th>Deskripsi</th>
                        <th>Tipe Izin</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($rows as $row) {
            $leaveType = '-';
            $status = strtolower($row->status ?? '');
            $isOvertime = $status === 'overtime' ? 'Ya' : '-';

            if (in_array($status, ['izin', 'cuti', 'sakit']) && $row->employee && $row->employee->leaveRequests) {
                $attendanceDate = Carbon::parse($row->tanggal);
                $leave = $row->employee->leaveRequests->first(function ($lr) use ($attendanceDate) {
                    return $attendanceDate->between(Carbon::parse($lr->tanggal_mulai), Carbon::parse($lr->tanggal_selesai));
                });
                if ($leave) {
                    $leaveType = ucwords(str_replace('_', ' ', $leave->tipe));
                }
            }

            $html .= '<tr>'
                . '<td>' . htmlspecialchars((string) $row->tanggal?->toDateString()) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->employee?->name ?? '')) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->employee?->position?->nama_posisi ?? '')) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->employee?->shift?->nama_shift ?? '')) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->jam_masuk ?? '')) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->jam_keluar ?? '')) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->status ?? '')) . '</td>'
                . '<td>' . htmlspecialchars($isOvertime) . '</td>'
                . '<td>' . htmlspecialchars((string) ($row->keterangan ?? '')) . '</td>'
                . '<td>' . htmlspecialchars($leaveType) . '</td>'
                . '</tr>';
        }

        $html .= '
                </tbody>
            </table>
        </body>
        </html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
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
            ->with(['employee.position', 'employee.shift'])
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
