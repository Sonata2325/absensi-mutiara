<?php

use App\Http\Controllers\Admin\AdminAttendanceMonitorController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPositionController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminLeaveRequestController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminShiftController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Karyawan\KaryawanAttendanceController;
use App\Http\Controllers\Karyawan\KaryawanDashboardController;
use App\Http\Controllers\Karyawan\KaryawanLeaveRequestController;
use App\Http\Controllers\Karyawan\KaryawanProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $user = request()->user();
    if ($user) {
        return redirect()->route(($user->role ?? '') === 'admin' ? 'admin.dashboard' : 'karyawan.dashboard');
    }

    return redirect()->route('login');
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'database' => \Illuminate\Support\Facades\DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => \Illuminate\Support\Facades\Cache::has('health_check') || \Illuminate\Support\Facades\Cache::put('health_check', 1, 10) ? 'ok' : 'fail',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'request.log'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('positions', AdminPositionController::class)->parameters(['positions' => 'position']);
    Route::resource('shifts', AdminShiftController::class)->parameters(['shifts' => 'shift']);
    Route::resource('karyawan', AdminEmployeeController::class)->parameters(['karyawan' => 'employee']);

    Route::get('/absensi/monitor', [AdminAttendanceMonitorController::class, 'index'])->name('attendance.monitor');

    Route::get('/izin', [AdminLeaveRequestController::class, 'index'])->name('leave.index');
    Route::post('/izin/{leave}/approve', [AdminLeaveRequestController::class, 'approve'])->name('leave.approve');
    Route::post('/izin/{leave}/reject', [AdminLeaveRequestController::class, 'reject'])->name('leave.reject');
    Route::post('/izin/{leave}/approve-cancellation', [AdminLeaveRequestController::class, 'approveCancellation'])->name('leave.approve_cancellation');

    Route::get('/laporan', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/absensi.csv', [AdminReportController::class, 'attendanceCsv'])->name('reports.attendance.csv');
    Route::get('/laporan/absensi.pdf', [AdminReportController::class, 'attendancePdf'])->name('reports.attendance.pdf');

    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/office', [AdminSettingsController::class, 'storeOffice'])->name('settings.office.store');
    Route::put('/settings/office/{office}', [AdminSettingsController::class, 'updateOffice'])->name('settings.office.update');
    Route::delete('/settings/office/{office}', [AdminSettingsController::class, 'destroyOffice'])->name('settings.office.destroy');

    Route::get('/file/{path}', function (string $path) {
        if (str_contains($path, '..')) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            abort(404);
        }

        return $disk->response($path);
    })->where('path', '.*')->name('file');
});

Route::prefix('karyawan')->name('karyawan.')->middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/beranda', [KaryawanDashboardController::class, 'index'])->name('dashboard');

    Route::get('/absensi', [KaryawanAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/absensi/clock-in', [KaryawanAttendanceController::class, 'clockIn'])->name('attendance.clock_in');
    Route::post('/absensi/clock-out', [KaryawanAttendanceController::class, 'clockOut'])->name('attendance.clock_out');
    Route::post('/absensi/overtime/start', [KaryawanAttendanceController::class, 'overtimeStart'])->name('attendance.overtime.start');
    Route::get('/absensi/riwayat', [KaryawanAttendanceController::class, 'history'])->name('attendance.history');
    Route::get('/absensi/slip.csv', [KaryawanAttendanceController::class, 'slipCsv'])->name('attendance.slip.csv');

    Route::get('/izin', [KaryawanLeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/izin/buat', [KaryawanLeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/izin', [KaryawanLeaveRequestController::class, 'store'])->name('leave.store');
    Route::delete('/izin/{leave}', [KaryawanLeaveRequestController::class, 'destroy'])->name('leave.destroy');
    Route::post('/izin/{leave}/cancel', [KaryawanLeaveRequestController::class, 'cancel'])->name('leave.cancel');

    Route::get('/profile', [KaryawanProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [KaryawanProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [KaryawanProfileController::class, 'updatePassword'])->name('profile.password');
});
