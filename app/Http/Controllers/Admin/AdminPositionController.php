<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class AdminPositionController extends Controller
{
    public function index()
    {
        $positions = Position::query()->orderBy('nama_posisi')->paginate(15);

        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_posisi' => ['required', 'string', 'max:255'],
            'kode_posisi' => ['required', 'string', 'max:50', 'unique:positions,kode_posisi'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Position::create($data);
        Cache::forget('positions_all');

        return redirect()->route('admin.positions.index')->with('status', 'Posisi berhasil dibuat.');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $data = $request->validate([
            'nama_posisi' => ['required', 'string', 'max:255'],
            'kode_posisi' => ['required', 'string', 'max:50', Rule::unique('positions', 'kode_posisi')->ignore($position->id)],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $position->update($data);
        Cache::forget('positions_all');

        return redirect()->route('admin.positions.index')->with('status', 'Posisi berhasil diupdate.');
    }

    public function destroy(Position $position)
    {
        if ($position->employees()->where('role', 'employee')->exists()) {
            return back()->with('status', 'Tidak bisa hapus posisi karena masih ada karyawan.');
        }

        $position->delete();
        Cache::forget('positions_all');

        return redirect()->route('admin.positions.index')->with('status', 'Posisi berhasil dihapus.');
    }
}
