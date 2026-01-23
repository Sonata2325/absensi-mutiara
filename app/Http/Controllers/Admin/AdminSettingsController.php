<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $settings = [
            'work_start_time' => Setting::getValue('work_start_time', '08:00'),
            'work_end_time' => Setting::getValue('work_end_time', '17:00'),
            'late_tolerance_minutes' => Setting::getValue('late_tolerance_minutes', '10'),
            'office_lat' => Setting::getValue('office_lat', ''),
            'office_lng' => Setting::getValue('office_lng', ''),
            'office_radius_meters' => Setting::getValue('office_radius_meters', '200'),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'work_start_time' => ['required', 'string'],
            'work_end_time' => ['required', 'string'],
            'late_tolerance_minutes' => ['required', 'integer', 'min:0'],
            'office_lat' => ['nullable', 'numeric'],
            'office_lng' => ['nullable', 'numeric'],
            'office_radius_meters' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value === null ? null : (string) $value);
        }
        Cache::forget('office_settings');

        return back()->with('status', 'Settings berhasil disimpan.');
    }
}
