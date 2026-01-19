<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminEmployeeController extends Controller
{
    public function index()
    {
        $employees = User::query()
            ->where('role', 'employee')
            ->with(['department', 'shift'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::query()->orderBy('nama_department')->get();
        $shifts = Shift::query()->orderBy('nama_shift')->get();

        return view('admin.employees.create', compact('departments', 'shifts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:50', 'unique:users,phone'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'position' => ['nullable', 'string', 'max:255'],
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

        $employee->load(['department', 'shift']);

        return view('admin.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $departments = Department::query()->orderBy('nama_department')->get();
        $shifts = Shift::query()->orderBy('nama_shift')->get();

        return view('admin.employees.edit', compact('employee', 'departments', 'shifts'));
    }

    public function update(Request $request, User $employee)
    {
        abort_unless($employee->role === 'employee', 404);

        $data = $request->validate([
            'nip' => ['required', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($employee->id)],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:50', Rule::unique('users', 'phone')->ignore($employee->id)],
            'department_id' => ['nullable', 'exists:departments,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'position' => ['nullable', 'string', 'max:255'],
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

        return redirect()->route('admin.karyawan.index')->with('status', 'Karyawan berhasil dihapus (soft delete).');
    }
}
