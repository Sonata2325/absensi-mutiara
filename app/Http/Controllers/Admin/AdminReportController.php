<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        [
            $startDate,
            $endDate,
            $start,
            $end,
            $startDt,
            $endDt,
            $startInput,
            $endInput,
        ] = $this->resolveRange($request);

        $attendances = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.position', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        $leaves = LeaveRequest::query()
            ->whereIn('status', ['approved', 'rejected', 'cancelled'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end])
                      ->orWhereBetween('tanggal_selesai', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('tanggal_mulai', '<', $start)
                            ->where('tanggal_selesai', '>', $end);
                      });
            })
            ->with(['employee.position', 'approver'])
            ->orderBy('tanggal_mulai')
            ->get();

        return view('admin.reports.index', [
            'start_date' => $startInput,
            'end_date' => $endInput,
            'start' => $start,
            'end' => $end,
            'attendances' => $attendances,
            'leaves' => $leaves,
        ]);
    }

    public function attendanceCsv(Request $request)
    {
        [
            $startDate,
            $endDate,
            $start,
            $end,
            $startDt,
            $endDt,
        ] = $this->resolveRange($request);

        $rows = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.position', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        $periodLabel = $startDate->equalTo($endDate)
            ? $startDate->translatedFormat('d F Y')
            : $startDate->translatedFormat('d F Y').' - '.$endDate->translatedFormat('d F Y');
        $filenameSuffix = $startDate->equalTo($endDate)
            ? $startDate->format('Y-m-d')
            : $startDate->format('Y-m-d').'-'.$endDate->format('Y-m-d');
        $filename = "laporan-absensi-{$filenameSuffix}.xls";

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
                    <td>: ' . htmlspecialchars($periodLabel) . '</td>
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
                    </tr>
                </thead>
                <tbody>';

        foreach ($rows as $row) {
            $status = strtolower($row->status ?? '');
            $isOvertime = $status === 'overtime' ? 'Ya' : '-';

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
                . '</tr>';
        }

        $leaves = LeaveRequest::query()
            ->whereIn('status', ['approved', 'rejected', 'cancelled'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end])
                      ->orWhereBetween('tanggal_selesai', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('tanggal_mulai', '<', $start)
                            ->where('tanggal_selesai', '>', $end);
                      });
            })
            ->with(['employee.position', 'approver'])
            ->orderBy('tanggal_mulai')
            ->get();

        if ($leaves->isNotEmpty()) {
            $html .= '
                </tbody>
            </table>
            
            <div class="title" style="margin-top: 30px;">REKAPITULASI IZIN / CUTI</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Tipe</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Disetujui Oleh</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($leaves as $leave) {
                $html .= '<tr>'
                    . '<td>' . htmlspecialchars((string) ($leave->employee?->name ?? '')) . '</td>'
                    . '<td>' . htmlspecialchars((string) ($leave->employee?->position?->nama_posisi ?? '')) . '</td>'
                    . '<td>' . htmlspecialchars(ucwords(str_replace('_', ' ', $leave->tipe))) . '</td>'
                    . '<td>' . htmlspecialchars($leave->tanggal_mulai?->format('d-m-Y')) . '</td>'
                    . '<td>' . htmlspecialchars($leave->tanggal_selesai?->format('d-m-Y')) . '</td>'
                    . '<td>' . htmlspecialchars($leave->alasan) . '</td>'
                    . '<td>' . htmlspecialchars(ucfirst($leave->status)) . '</td>'
                    . '<td>' . htmlspecialchars((string) ($leave->approver?->name ?? '-')) . '</td>'
                    . '</tr>';
            }
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
        [
            $startDate,
            $endDate,
            $start,
            $end,
            $startDt,
            $endDt,
        ] = $this->resolveRange($request);

        $attendances = Attendance::query()
            ->whereBetween('tanggal', [$startDt, $endDt])
            ->with(['employee.position', 'employee.shift'])
            ->orderBy('tanggal')
            ->orderBy('employee_id')
            ->get();

        $leaves = LeaveRequest::query()
            ->whereIn('status', ['approved', 'rejected', 'cancelled'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end])
                      ->orWhereBetween('tanggal_selesai', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('tanggal_mulai', '<', $start)
                            ->where('tanggal_selesai', '>', $end);
                      });
            })
            ->with(['employee.position', 'approver'])
            ->orderBy('tanggal_mulai')
            ->get();

        return view('admin.reports.pdf', [
            'start' => $start,
            'end' => $end,
            'attendances' => $attendances,
            'leaves' => $leaves,
        ]);
    }

    private function resolveRange(Request $request): array
    {
        $startInput = $request->query('start_date');
        $endInput = $request->query('end_date');

        $startDate = $this->parseDate($startInput);
        $endDate = $this->parseDate($endInput);

        if (! $startDate && ! $endDate) {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($startDate && ! $endDate) {
            $endDate = $startDate->copy();
        } elseif (! $startDate && $endDate) {
            $startDate = $endDate->copy();
        }

        if ($startDate->greaterThan($endDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $start = $startDate->toDateString();
        $end = $endDate->toDateString();

        return [
            $startDate,
            $endDate,
            $start,
            $end,
            $startDate->copy()->startOfDay()->toDateTimeString(),
            $endDate->copy()->endOfDay()->toDateTimeString(),
            $startInput ?? $start,
            $endInput ?? $end,
        ];
    }

    private function parseDate(?string $value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
