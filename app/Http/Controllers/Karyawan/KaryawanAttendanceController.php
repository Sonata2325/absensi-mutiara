<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class KaryawanAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $yesterday = now()->subDay()->toDateString();
        $attendanceYesterday = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $yesterday)
            ->first();
        if ($attendanceYesterday && $attendanceYesterday->jam_masuk && ! $attendanceYesterday->jam_keluar) {
            $endTime = $attendanceYesterday->status === 'overtime' ? '22:00:00' : '23:59:59';
            $attendanceYesterday->update(['jam_keluar' => $endTime]);
        }

        $attendance = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($attendance && $attendance->status === 'overtime' && ! $attendance->jam_keluar) {
            $limit = \Illuminate\Support\Carbon::parse($today.' 22:00');
            if (now()->greaterThanOrEqualTo($limit)) {
                $attendance->update(['jam_keluar' => '22:00:00']);
            }
        }

        $leaveToday = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();

        $settings = Cache::remember('office_settings', 600, function () {
            return [
                'office_lat' => Setting::getValue('office_lat', ''),
                'office_lng' => Setting::getValue('office_lng', ''),
                'office_radius_meters' => (int) (Setting::getValue('office_radius_meters', '200') ?? '200'),
            ];
        });

        return view('karyawan.attendance.index', [
            'attendance' => $attendance,
            'leaveToday' => $leaveToday,
            'settings' => $settings,
        ]);
    }

    public function clockIn(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();
        $tanggalStore = now()->startOfDay()->toDateTimeString();

        $leaveToday = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();
        if ($leaveToday) {
            return back()->with('status', 'Kamu sedang izin hari ini, tidak bisa clock in.');
        }

        $data = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'foto_masuk' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $shift = $user->shift;
        $isFlexible = $shift && $shift->is_flexible;

        if (! $isFlexible && ! $this->isWithinOffice((float) $data['lat'], (float) $data['lng'])) {
            return back()->with('status', 'Lokasi di luar radius kantor.');
        }

        $attendance = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($attendance && $attendance->jam_masuk) {
            return back()->with('status', 'Kamu sudah clock in hari ini.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto_masuk')) {
            $fotoPath = $this->storeCompressedImage($request->file('foto_masuk'), 'absensi', 75, 1080);
        }

        $status = $this->resolveClockInStatus($user, now());

        if ($attendance) {
            $attendance->update([
                'jam_masuk' => now()->format('H:i:s'),
                'lokasi_masuk_lat' => (float) $data['lat'],
                'lokasi_masuk_lng' => (float) $data['lng'],
                'foto_masuk' => $fotoPath,
                'status' => $status,
            ]);
        } else {
            Attendance::create([
                'employee_id' => $user->id,
                'tanggal' => $tanggalStore,
                'jam_masuk' => now()->format('H:i:s'),
                'lokasi_masuk_lat' => (float) $data['lat'],
                'lokasi_masuk_lng' => (float) $data['lng'],
                'foto_masuk' => $fotoPath,
                'status' => $status,
            ]);
        }

        return back()->with('status', 'Clock in berhasil.');
    }

    public function clockOut(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $data = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'foto_keluar' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        $shift = $user->shift;
        $isFlexible = $shift && $shift->is_flexible;

        if (! $isFlexible && ! $this->isWithinOffice((float) $data['lat'], (float) $data['lng'])) {
            return back()->with('status', 'Lokasi di luar radius kantor.');
        }

        $attendance = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $attendance || ! $attendance->jam_masuk) {
            return back()->with('status', 'Kamu belum clock in hari ini.');
        }

        if ($attendance->jam_keluar) {
            return back()->with('status', 'Kamu sudah clock out hari ini.');
        }

        if (\Illuminate\Support\Carbon::parse($today)->isWeekend() && ($attendance->status !== 'overtime')) {
            return back()->with('status', 'Weekend over time: klik tombol Over Time terlebih dahulu.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto_keluar')) {
            $fotoPath = $this->storeCompressedImage($request->file('foto_keluar'), 'absensi', 75, 1080);
        }

        $attendance->update([
            'jam_keluar' => now()->format('H:i:s'),
            'lokasi_keluar_lat' => (float) $data['lat'],
            'lokasi_keluar_lng' => (float) $data['lng'],
            'foto_keluar' => $fotoPath,
        ]);

        return back()->with('status', 'Clock out berhasil.');
    }

    public function overtimeStart(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $leaveToday = LeaveRequest::query()
            ->where('employee_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($leaveToday) {
            return back()->with('status', 'Kamu sedang izin hari ini, tidak bisa over time.');
        }

        $attendance = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $attendance || ! $attendance->jam_masuk) {
            return back()->with('status', 'Hanya bisa klik tombol over time setelah clock in.');
        }

        if ($attendance->jam_keluar) {
            return back()->with('status', 'Kamu sudah clock out hari ini.');
        }

        if (($attendance->status ?? '') === 'overtime') {
            return back()->with('status', 'Over time sudah dimulai.');
        }

        $now = now();
        if ($now->isWeekend()) {
            $start = \Illuminate\Support\Carbon::parse($now->toDateString().' 07:00');
            if ($now->lessThan($start)) {
                return back()->with('status', 'Over time belum dimulai');
            }
        } else {
            $start = \Illuminate\Support\Carbon::parse($now->toDateString().' 18:50');
            if ($now->lessThan($start)) {
                return back()->with('status', 'Over time mulai jam 7.00 malam');
            }
        }

        $request->validate([
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $deskripsi = $request->input('deskripsi');
        $overtimeNote = 'Over Time mulai '.now()->format('H:i');
        
        if ($deskripsi) {
            $overtimeNote .= ' - ' . $deskripsi;
        }

        $attendance->update([
            'status' => 'overtime',
            'keterangan' => trim((string) ($attendance->keterangan ? $attendance->keterangan.' ' : '').$overtimeNote),
        ]);

        return back()->with('status', 'Over time dimulai.');
    }

    public function history(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay()->toDateTimeString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()->toDateTimeString();

        $attendances = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereBetween('tanggal', [$start, $end])
            ->orderByDesc('tanggal')
            ->paginate(20);

        return view('karyawan.attendance.history', compact('attendances', 'month', 'year'));
    }

    public function slipCsv(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay()->toDateTimeString();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay()->toDateTimeString();

        $rows = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get();

        $filename = "slip-kehadiran-{$year}-".str_pad((string) $month, 2, '0', STR_PAD_LEFT).'.xls';

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $html = '
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <style>
                table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
                th, td { border: 1px solid #000000; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .title { font-size: 16px; font-weight: bold; margin-bottom: 20px; text-align: center; }
                .info { margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <div class="title">SLIP KEHADIRAN KARYAWAN</div>
            <div class="info">
                <table>
                    <tr>
                        <td style="border:none; width: 150px;">Nama Karyawan</td>
                        <td style="border:none;">: ' . htmlspecialchars($user->name) . '</td>
                    </tr>
                    <tr>
                        <td style="border:none;">Periode</td>
                        <td style="border:none;">: ' . htmlspecialchars($monthName) . '</td>
                    </tr>
                    <tr>
                        <td style="border:none;">Perusahaan</td>
                        <td style="border:none;">: PT Mutiara Jaya Express</td>
                    </tr>
                </table>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th style="background-color: #D61600; color: white;">Tanggal</th>
                        <th style="background-color: #D61600; color: white;">Jam Masuk</th>
                        <th style="background-color: #D61600; color: white;">Jam Keluar</th>
                        <th style="background-color: #D61600; color: white;">Status</th>
                        <th style="background-color: #D61600; color: white;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>
                <td>' . ($row->tanggal ? $row->tanggal->translatedFormat('d F Y') : '-') . '</td>
                <td>' . ($row->jam_masuk ?? '-') . '</td>
                <td>' . ($row->jam_keluar ?? '-') . '</td>
                <td>' . ucfirst($row->status ?? '-') . '</td>
                <td>' . ($row->keterangan ?? '-') . '</td>
            </tr>';
        }

        $html .= '
                </tbody>
            </table>
        </body>
        </html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function resolveClockInStatus($user, Carbon $now): string
    {
        $shift = $user->shift;

        if ($shift && $shift->is_flexible) {
            return 'hadir';
        }

        if ($shift && $shift->jam_masuk) {
            $toleransi = (int) ($shift->toleransi_terlambat ?? 0);
            $limit = Carbon::parse($now->toDateString().' '.$shift->jam_masuk)->addMinutes($toleransi);

            return $now->lessThanOrEqualTo($limit) ? 'hadir' : 'terlambat';
        }

        $startTime = Setting::getValue('work_start_time', '08:00') ?? '08:00';
        $tolerance = (int) (Setting::getValue('late_tolerance_minutes', '10') ?? '10');
        $limit = Carbon::parse($now->toDateString().' '.$startTime)->addMinutes($tolerance);

        return $now->lessThanOrEqualTo($limit) ? 'hadir' : 'terlambat';
    }

    private function storeCompressedImage($file, string $folder, int $quality, int $maxWidth): ?string
    {
        if (! function_exists('imagecreatefromjpeg')) {
            return $file->store($folder, 'public');
        }

        $mime = (string) $file->getMimeType();
        if (! in_array($mime, ['image/jpeg', 'image/png'], true)) {
            return $file->store($folder, 'public');
        }

        $sourcePath = $file->getRealPath();
        if (! $sourcePath) {
            return $file->store($folder, 'public');
        }

        $image = $mime === 'image/png'
            ? @imagecreatefrompng($sourcePath)
            : @imagecreatefromjpeg($sourcePath);

        if (! $image) {
            return $file->store($folder, 'public');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * $ratio);
        }

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $dir = $folder.'/'.now()->format('Y/m');
        Storage::disk('public')->makeDirectory($dir);
        $filename = now()->format('YmdHis').'-'.bin2hex(random_bytes(6)).'.jpg';
        $path = $dir.'/'.$filename;
        $fullPath = Storage::disk('public')->path($path);

        imagejpeg($canvas, $fullPath, $quality);
        imagedestroy($canvas);
        imagedestroy($image);

        return $path;
    }

    private function isWithinOffice(float $lat, float $lng): bool
    {
        $officeLat = Setting::getValue('office_lat', null);
        $officeLng = Setting::getValue('office_lng', null);
        $radius = (int) (Setting::getValue('office_radius_meters', '200') ?? '200');

        if ($officeLat === null || $officeLng === null || $officeLat === '' || $officeLng === '') {
            return true;
        }

        $distance = $this->haversineMeters($lat, $lng, (float) $officeLat, (float) $officeLng);

        return $distance <= $radius;
    }

    private function haversineMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000.0;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
