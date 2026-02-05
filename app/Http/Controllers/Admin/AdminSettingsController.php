<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeLocation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $offices = OfficeLocation::all();

        return view('admin.settings.edit', compact('offices'));
    }

    public function update(Request $request)
    {
        // Settings general (work_start_time, dll) sudah dihapus karena digantikan oleh Shift.
        // Method ini dibiarkan kosong atau bisa dihapus jika route-nya juga dihapus.
        return back()->with('status', 'Pengaturan berhasil diperbarui.');
    }

    public function storeOffice(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1'],
            'address' => ['nullable', 'string'],
        ]);

        OfficeLocation::create($data);

        return back()->with('status', 'Lokasi kantor berhasil ditambahkan.');
    }

    public function updateOffice(Request $request, OfficeLocation $office)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'integer', 'min:1'],
            'address' => ['nullable', 'string'],
        ]);

        $office->update($data);

        return back()->with('status', 'Lokasi kantor berhasil diupdate.');
    }

    public function destroyOffice(OfficeLocation $office)
    {
        // Check if used by users
        if ($office->users()->exists()) {
             // Optional: Force set null or block delete. 
             // Since we set nullOnDelete in migration, it is safe to delete, 
             // but maybe warn user? For now let's just delete as per common requirement.
        }
        
        $office->delete();

        return back()->with('status', 'Lokasi kantor berhasil dihapus.');
    }
}
