<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class KaryawanAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $attendance = Attendance::query()
            ->where('employee_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

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

        if (! $this->isWithinOffice((float) $data['lat'], (float) $data['lng'])) {
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
            $fotoPath = $request->file('foto_masuk')->store('absensi', 'public');
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

        if (! $this->isWithinOffice((float) $data['lat'], (float) $data['lng'])) {
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

        $fotoPath = null;
        if ($request->hasFile('foto_keluar')) {
            $fotoPath = $request->file('foto_keluar')->store('absensi', 'public');
        }

        $attendance->update([
            'jam_keluar' => now()->format('H:i:s'),
            'lokasi_keluar_lat' => (float) $data['lat'],
            'lokasi_keluar_lng' => (float) $data['lng'],
            'foto_keluar' => $fotoPath,
        ]);

        return back()->with('status', 'Clock out berhasil.');
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

        $filename = "slip-kehadiran-{$year}-".str_pad((string) $month, 2, '0', STR_PAD_LEFT).'.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Tanggal', 'Jam Masuk', 'Jam Keluar', 'Status', 'Keterangan']);
        foreach ($rows as $row) {
            fputcsv($handle, [
                (string) $row->tanggal?->toDateString(),
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

    private function resolveClockInStatus($user, Carbon $now): string
    {
        $shift = $user->shift;
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
