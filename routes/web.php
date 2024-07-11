<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk guest Karyawan
Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/login/karyawan', function () {
        return view('auth.login_karyawan');
    })->name('login.karyawan');

    Route::post('/login/karyawan', [AuthController::class, 'prosesLoginKaryawan'])->name('karyawan.login.process');
});

// Route untuk guest Administrator
Route::middleware(['guest:administrator'])->group(function () {
    Route::get('/login/administrator', function () {
        return view('auth.login_administrator');
    })->name('login.administrator');

    Route::post('/login/administrator', [AuthController::class, 'prosesLoginAdmin'])->name('administrator.login.process');
});

// Route untuk Karyawan yang terautentikasi
Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [DashboardController::class, 'index'])->name('karyawan.dashboard');
    Route::post('/karyawan/logout', [AuthController::class, 'prosesLogoutKaryawan'])->name('karyawan.logout');

    Route::prefix('karyawan')->group(function () {
        Route::get('/presensi/create', [PresensiController::class, 'create'])->name('karyawan.presensi.create');
        Route::post('/presensi/simpan-presensi', [PresensiController::class, 'simpanPresensi'])->name('karyawan.presensi.simpan');
        Route::post('/presensi/simpan-izin', [PresensiController::class, 'simpanIzin'])->name('karyawan.presensi.izin.simpan');
        Route::get('/profile', [PresensiController::class, 'editProfile'])->name('karyawan.profile.perbarui');
        Route::post('/profile/{nuptk}', [PresensiController::class, 'perbaruiProfile'])->name('karyawan.profile.simpan-pembaruan');
        Route::get('/presensi/riwayat-presensi', [PresensiController::class, 'riwayat'])->name('karyawan.presensi.riwayat');
        Route::post('/presensi/riwayat', [PresensiController::class, 'dapatkanRiwayat'])->name('karyawan.presensi.riwayat.get');
        Route::get('/izin', [PresensiController::class, 'listIzin'])->name('karyawan.presensi.izin.daftar');
        Route::get('/izin/buat-izin', [PresensiController::class, 'buatIzin'])->name('karyawan.presensi.izin.buat');
    });
});

// Route untuk Administrator yang terautentikasi
Route::middleware(['auth:administrator'])->group(function () {
    Route::post('/admin/logout', [AuthController::class, 'prosesLogoutAdmin'])->name('admin.logout');
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('admin.dashboard');

    Route::prefix('administrator')->group(function () {
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('admin.karyawan.index');
        Route::post('/karyawan/simpanKaryawan', [KaryawanController::class, 'simpanKaryawan'])->name('admin.karyawan.simpan');
        Route::post('/karyawan/ubah', [KaryawanController::class, 'ubahKaryawan'])->name('admin.karyawan.ubah');
        Route::post('/karyawan/{nuptk}/perbarui', [KaryawanController::class, 'perbaruiKaryawan'])->name('admin.karyawan.perbarui');
        Route::post('/karyawan/{nuptk}/hapus', [KaryawanController::class, 'deleteKaryawan'])->name('admin.karyawan.hapus');

        Route::prefix('presensi')->group(function () {
            Route::get('/monitoring', [PresensiController::class, 'monitoringPresensi'])->name('admin.presensi.monitoring');
            Route::post('/dapatkan', [PresensiController::class, 'getPresensiAdmin'])->name('admin.presensi.dapatkan');
            Route::get('/laporan', [PresensiController::class, 'laporanPresensi'])->name('admin.presensi.laporan');
            Route::post('/laporan/cetak', [PresensiController::class, 'cetakLaporanPresensi'])->name('admin.presensi.laporan.cetak');
            Route::get('/rekapitulasi', [PresensiController::class, 'rekapPresensi'])->name('admin.presensi.rekapitulasi');
            Route::post('/rekapitulasi/cetak', [PresensiController::class, 'cetakRekapPresensi'])->name('admin.presensi.rekapitulasi.cetak');
            Route::get('/izin-sakit', [PresensiController::class, 'izinsakitList'])->name('admin.presensi.izin-sakit.daftar');
            Route::post('/izin-sakit/setujui', [PresensiController::class, 'approveIzinSakit'])->name('admin.presensi.izin-sakit.setujui');
            Route::get('/izin-sakit/{id}/batal', [PresensiController::class, 'cancelIzinSakit'])->name('admin.presensi.izin-sakit.batal');
        });
    });
});
