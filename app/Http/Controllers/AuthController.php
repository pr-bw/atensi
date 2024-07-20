<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function prosesLoginGuru(Request $request)
    {
        if (Auth::guard('guru')->attempt(['nuptk' => $request->nuptk, 'password' => $request->password])) {
            return redirect()->route('guru.dashboard');
        } else {
            return redirect()->route('login.guru')->with(['warning' => 'NUPTK/Password Salah']);
        }
    }

    public function prosesLogoutGuru(Request $request)
    {
        Auth::guard('guru')->logout();

        // Hapus sesi dan arahkan ke halaman utama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(['success' => 'Anda telah berhasil keluar.']);
    }

    public function prosesLoginAdministrator(Request $request)
    {
        if (Auth::guard('administrator')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('administrator.dashboard');
        } else {
            return redirect()->route('login.administrator')->with(['warning' => 'Email / Password Salah']);
        }
    }

    public function prosesLogoutAdministrator(Request $request)
    {
        Auth::guard('administrator')->logout();

        // Hapus sesi dan arahkan ke halaman utama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with(['success' => 'Anda telah berhasil keluar.']);
    }
}
