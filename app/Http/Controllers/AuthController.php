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

        if (! Auth::attempt($credentials, $remember)) {
            Log::warning('Login gagal', [
                'phone' => $credentials['phone'],
                'ip' => $request->ip(),
            ]);
            return back()
                ->withErrors(['phone' => 'Nomor Telepon atau password salah.'])
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
