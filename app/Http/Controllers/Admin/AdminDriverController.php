<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class AdminDriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::query()->orderBy('nama')->get();
        return view('admin.drivers.index', ['drivers' => $drivers]);
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:50'],
            'nomor_sim' => ['required', 'string', 'unique:drivers,nomor_sim', 'max:50'],
        ]);

        $validated['status'] = 'aktif'; // Default status

        Driver::create($validated);

        return redirect()->route('admin.drivers.index')->with('status', 'Driver berhasil ditambahkan.');
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', ['driver' => $driver]);
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:50'],
            'nomor_sim' => ['required', 'string', 'unique:drivers,nomor_sim,' . $driver->id, 'max:50'],
            'status' => ['required', 'string', 'in:aktif,sedang_bertugas,nonaktif'],
        ]);

        $driver->update($validated);

        return redirect()->route('admin.drivers.index')->with('status', 'Data driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->status === 'sedang_bertugas') {
            return redirect()->back()->with('status', 'Driver sedang bertugas, tidak bisa dihapus.');
        }

        $driver->delete();

        return redirect()->route('admin.drivers.index')->with('status', 'Driver berhasil dihapus.');
    }
}
