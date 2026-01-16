<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('karyawan.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'kontak_darurat' => ['nullable', 'string', 'max:255'],
            'foto_profile' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:4096'],
        ]);

        if ($request->hasFile('foto_profile')) {
            $data['foto_profile'] = $request->file('foto_profile')->store('profile', 'public');
        } else {
            unset($data['foto_profile']);
        }

        $user->update($data);

        return back()->with('status', 'Profile berhasil diupdate.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $user->getAuthPassword())) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => $data['new_password']]);

        return back()->with('status', 'Password berhasil diubah.');
    }
}
