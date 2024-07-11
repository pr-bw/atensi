<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Proses login untuk Karyawan
    public function prosesLoginKaryawan(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nuptk' => $request->nuptk, 'password' => $request->password])) {
            return redirect()->route('karyawan.dashboard');
        } else {
            return redirect()->route('login.karyawan')->with(['warning' => 'NUPTK/Password Salah']);
        }
    }

    // Proses login untuk Admin (User)
    public function prosesLoginAdmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('administrator.dashboard');
        } else {
            return redirect()->route('login.administrator')->with(['warning' => 'Email / Password Salah']);
        }
    }

    // Proses logout untuk Karyawan
    public function prosesLogoutKaryawan(Request $request)
    {
        Auth::guard('karyawan')->logout();

        // Hapus sesi dan arahkan ke halaman utama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with(['success' => 'Anda telah berhasil keluar.']);
    }

    // Proses logout untuk Admin (User)
    public function prosesLogoutAdmin(Request $request)
    {
        Auth::guard('administrator')->logout();

        // Hapus sesi dan arahkan ke halaman utama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with(['success' => 'Anda telah berhasil keluar.']);
    }
}
