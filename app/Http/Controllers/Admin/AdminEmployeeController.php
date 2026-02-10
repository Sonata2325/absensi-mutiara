<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\OfficeLocation;
use App\Models\Position;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class AdminEmployeeController extends Controller
{
    public function index()
    {
        $employees = User::query()
            ->where('role', 'employee')
            ->with(['position', 'shift'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Cache::remember('positions_all', 3600, function () {
            return Position::query()->orderBy('nama_posisi')->get();
        });
        $shifts = Cache::remember('shifts_all', 3600, function () {
            return Shift::query()->orderBy('nama_shift')->get();
        });
        $offices = OfficeLocation::query()->orderBy('name')->get();

        return view('admin.employees.create', compact('positions', 'shifts', 'offices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:50', 'unique:users,phone'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'office_location_id' => ['nullable', 'exists:office_locations,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'alamat' => ['nullable', 'string'],
            'kontak_darurat' => ['nullable', 'string', 'max:255'],
        ]);

        $data['role'] = 'employee';

        User::create($data);

        return redirect()->route('admin.karyawan.index')->with('status', 'Karyawan berhasil ditambahkan.');
    }

    public function show(User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $employee->load(['position', 'shift']);

        $usedAnnual = LeaveRequest::query()
            ->where('employee_id', $employee->id)
            ->where('tipe', 'cuti_tahunan')
            ->whereIn('status', ['approved', 'pending'])
            ->whereYear('tanggal_mulai', now()->year)
            ->get()
            ->sum(function ($leave) {
                return Carbon::parse($leave->tanggal_mulai)
                    ->diffInDays(Carbon::parse($leave->tanggal_selesai)) + 1;
            });

        $remainingAnnual = max(0, 12 - (int) $usedAnnual);

        return view('admin.employees.show', [
            'employee' => $employee,
            'remainingAnnual' => $remainingAnnual,
            'usedAnnual' => (int) $usedAnnual,
        ]);
    }

    public function edit(User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $positions = Cache::remember('positions_all', 3600, function () {
            return Position::query()->orderBy('nama_posisi')->get();
        });
        $shifts = Cache::remember('shifts_all', 3600, function () {
            return Shift::query()->orderBy('nama_shift')->get();
        });
        $offices = OfficeLocation::query()->orderBy('name')->get();

        return view('admin.employees.edit', compact('employee', 'positions', 'shifts', 'offices'));
    }

    public function update(Request $request, User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:50', Rule::unique('users', 'phone')->ignore($employee->id)],
            'position_id' => ['nullable', 'exists:positions,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'office_location_id' => ['nullable', 'exists:office_locations,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'alamat' => ['nullable', 'string'],
            'kontak_darurat' => ['nullable', 'string', 'max:255'],
        ]);

        if (($data['password'] ?? '') === '') {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('admin.karyawan.index')->with('status', 'Karyawan berhasil diupdate.');
    }

    public function destroy(User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $employee->delete();

        return redirect()->route('admin.karyawan.index')->with('status', 'Karyawan berhasil dihapus.');
    }
}
