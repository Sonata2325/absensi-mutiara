<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::query()->orderBy('nama_department')->paginate(15);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_department' => ['required', 'string', 'max:255'],
            'kode_department' => ['required', 'string', 'max:50', 'unique:departments,kode_department'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index')->with('status', 'Department berhasil dibuat.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'nama_department' => ['required', 'string', 'max:255'],
            'kode_department' => ['required', 'string', 'max:50', Rule::unique('departments', 'kode_department')->ignore($department->id)],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index')->with('status', 'Department berhasil diupdate.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->where('role', 'employee')->exists()) {
            return back()->with('status', 'Tidak bisa hapus department karena masih ada karyawan.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('status', 'Department berhasil dihapus.');
    }
}
