<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;

class AdminTruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::query()->orderBy('plat_nomor')->get();
        return view('admin.trucks.index', ['trucks' => $trucks]);
    }

    public function create()
    {
        return view('admin.trucks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plat_nomor' => ['required', 'string', 'unique:trucks,plat_nomor', 'max:20'],
            'jenis_armada' => ['required', 'string', 'in:cde,cdd,fuso,tronton_wingbox'],
            'kapasitas_kg' => ['required', 'numeric', 'min:1'],
        ]);

        $validated['status'] = 'tersedia'; // Default status

        Truck::create($validated);

        return redirect()->route('admin.trucks.index')->with('status', 'Truck berhasil ditambahkan.');
    }

    public function edit(Truck $truck)
    {
        return view('admin.trucks.edit', ['truck' => $truck]);
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'plat_nomor' => ['required', 'string', 'unique:trucks,plat_nomor,' . $truck->id, 'max:20'],
            'jenis_armada' => ['required', 'string', 'in:cde,cdd,fuso,tronton_wingbox'],
            'kapasitas_kg' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'string', 'in:tersedia,dalam_perjalanan,perbaikan'],
        ]);

        $truck->update($validated);

        return redirect()->route('admin.trucks.index')->with('status', 'Data truck berhasil diperbarui.');
    }

    public function destroy(Truck $truck)
    {
        if ($truck->status === 'dalam_perjalanan') {
            return redirect()->back()->with('status', 'Truck sedang dalam perjalanan, tidak bisa dihapus.');
        }

        $truck->delete();

        return redirect()->route('admin.trucks.index')->with('status', 'Truck berhasil dihapus.');
    }
}
