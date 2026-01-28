<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::query()->orderBy('nama_shift')->paginate(15);

        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('admin.shifts.create');
    }

    public function store(Request $request)
    {
        $isFlexible = $request->boolean('is_flexible');

        $data = $request->validate([
            'nama_shift' => ['required', 'string', 'max:255'],
            'jam_masuk' => $isFlexible ? ['nullable'] : ['required'],
            'jam_keluar' => $isFlexible ? ['nullable'] : ['required'],
            'toleransi_terlambat' => ['nullable', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_flexible' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_flexible'] = $isFlexible;
        $data['toleransi_terlambat'] = (int) ($data['toleransi_terlambat'] ?? 0);

        if ($isFlexible) {
            $data['jam_masuk'] = null;
            $data['jam_keluar'] = null;
        }

        Shift::create($data);
        Cache::forget('shifts_all');

        return redirect()->route('admin.shifts.index')->with('status', 'Shift berhasil dibuat.');
    }

    public function edit(Shift $shift)
    {
        return view('admin.shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $isFlexible = $request->boolean('is_flexible');

        $data = $request->validate([
            'nama_shift' => ['required', 'string', 'max:255'],
            'jam_masuk' => $isFlexible ? ['nullable'] : ['required'],
            'jam_keluar' => $isFlexible ? ['nullable'] : ['required'],
            'toleransi_terlambat' => ['nullable', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_flexible' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_flexible'] = $isFlexible;
        $data['toleransi_terlambat'] = (int) ($data['toleransi_terlambat'] ?? 0);

        if ($isFlexible) {
            $data['jam_masuk'] = null;
            $data['jam_keluar'] = null;
        }

        $shift->update($data);
        Cache::forget('shifts_all');

        return redirect()->route('admin.shifts.index')->with('status', 'Shift berhasil diupdate.');
    }

    public function destroy(Shift $shift)
    {
        if ($shift->employees()->where('role', 'employee')->exists()) {
            return back()->with('status', 'Tidak bisa hapus shift karena masih ada karyawan.');
        }

        $shift->delete();
        Cache::forget('shifts_all');

        return redirect()->route('admin.shifts.index')->with('status', 'Shift berhasil dihapus.');
    }
}
