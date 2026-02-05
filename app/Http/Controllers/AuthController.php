<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $remember = $request->boolean('remember');

        // Tambahkan pengecekan status aktif
        $credentials['status'] = 'aktif';

        // Note: We enforce SESSION_LIFETIME (24h) and disable the long-lived 'remember_token' (5 years)
        // to ensure users are logged out after 24 hours of inactivity.
        // We pass 'false' for the remember parameter to Auth::attempt regardless of the checkbox.
        // The session itself will persist for 24 hours (1440 minutes) as configured in .env.
        if (! Auth::attempt($credentials, false)) {
            return back()
                ->withErrors(['phone' => 'Nomor Telepon atau password salah, atau akun tidak aktif.'])
                ->onlyInput('phone');
        }

        $request->session()->regenerate();

        $user = $request->user();
        Log::info('Login berhasil', [
            'user_id' => $user?->id,
            'role' => $user?->role,
            'ip' => $request->ip(),
        ]);
        if (($user->role ?? '') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('karyawan.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
