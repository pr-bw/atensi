<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\guruController;
use App\Http\Controllers\KonfigurasiLokasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk guest guru
Route::middleware(['guest:guru'])->group(function () {
    Route::get('/login/guru', function () {
        return view('auth.login_guru');
    })->name('login.guru');

    Route::post('/login/guru', [AuthController::class, 'prosesLoginGuru'])->name('guru.login.process');
});

// Route untuk guest Administrator
Route::middleware(['guest:administrator'])->group(function () {
    Route::get('/login/administrator', function () {
        return view('auth.login_administrator');
    })->name('login.administrator');

    Route::post('/login/administrator', [AuthController::class, 'prosesLoginAdministrator'])->name('administrator.login.process');
});

// Route untuk guru yang terautentikasi
Route::middleware(['auth:guru'])->group(function () {
    Route::get('/guru/dashboard', [DashboardController::class, 'index'])->name('guru.dashboard');
    Route::post('/guru/logout', [AuthController::class, 'prosesLogoutGuru'])->name('guru.logout');

    Route::prefix('guru')->group(function () {
        Route::get('/presensi/create', [PresensiController::class, 'create'])->name('guru.presensi.create');
        Route::post('/presensi/simpan-presensi', [PresensiController::class, 'simpanPresensi'])->name('guru.presensi.simpan');
        Route::get('/profile', [PresensiController::class, 'editProfile'])->name('guru.profile.perbarui');
        Route::post('/profile/{nuptk}', [PresensiController::class, 'perbaruiProfile'])->name('guru.profile.simpan-pembaruan');
        Route::get('/presensi/riwayat-presensi', [PresensiController::class, 'riwayat'])->name('guru.presensi.riwayat');
        Route::post('/presensi/riwayat', [PresensiController::class, 'dapatkanRiwayat'])->name('guru.presensi.riwayat.get');
        Route::get('/izin/buat-izin', [PresensiController::class, 'buatIzin'])->name('guru.presensi.izin.buat');
        Route::post('/presensi/simpan-izin', [PresensiController::class, 'simpanIzin'])->name('guru.presensi.izin.simpan');
        Route::get('/izin', [PresensiController::class, 'listIzin'])->name('guru.presensi.izin.daftar');
        Route::post('/presensi/cek-pengajuan-izin', [PresensiController::class, 'cekPengajuanIzin']);
    });
});

// Route untuk Administrator yang terautentikasi
Route::middleware(['auth:administrator'])->group(function () {
    Route::post('/administrator/logout', [AuthController::class, 'prosesLogoutAdministrator'])->name('administrator.logout');
    Route::get('/administrator/dashboard', [DashboardController::class, 'dashboardAdministrator'])->name('administrator.dashboard');

    Route::prefix('administrator')->group(function () {
        Route::get('/guru', [GuruController::class, 'index'])->name('administrator.guru.index');
        Route::post('/guru/simpan-guru', [GuruController::class, 'simpanguru'])->name('administrator.guru.simpan');
        Route::post('/guru/tambah-data-guru', [GuruController::class, 'tambahDataGuruDariAdministrator']);
        Route::post('/guru/ubah', [GuruController::class, 'ubahDataGuru'])->name('administrator.guru.ubah-data');
        Route::post('/guru/{nuptk}/perbarui', [GuruController::class, 'perbaruiDataGuru'])->name('administrator.guru.perbarui-data');
        Route::post('/guru/{nuptk}/hapus', [GuruController::class, 'hapusDataGuru'])->name('administrator.guru.hapus');
        Route::get('/konfigurasi/lokasi-sekolah', [KonfigurasiLokasiController::class, 'lokasiSekolah']);
        Route::post('/konfigurasi/lokasi-sekolah/update', [KonfigurasiLokasiController::class, 'perbaruiRadiusDanLokasiSekolah']);

        Route::prefix('presensi')->group(function () {
            Route::get('/monitoring', [PresensiController::class, 'monitoringPresensi']);
            Route::post('/monitoring/rekap-presensi-harian', [PresensiController::class, 'tampilkanRekapPresensiHarian'])->name('administrator.presensi.monitoring.rekap-presensi-harian');
            Route::get('/laporan/guru', [PresensiController::class, 'laporanPresensi']);
            Route::post('/laporan/guru/cetak', [PresensiController::class, 'cetakLaporanPresensi']);
            Route::post('/laporan/guru/export-pdf', [PresensiController::class, 'exportToPDF']);
            Route::post('/laporan/guru/export-excel', [PresensiController::class, 'cetakRekapitulasiPresensi'])->name('export.rekap.presensi');
            Route::get('/rekapitulasi', [PresensiController::class, 'rekapitulasiPresensi']);
            Route::post('/rekapitulasi/cetak', [PresensiController::class, 'cetakRekapitulasiPresensi']);
            Route::get('/izin-sakit-guru', [PresensiController::class, 'izinDanSakitGuru']);
            Route::post('/izin-sakit-guru/setujui', [PresensiController::class, 'setujuiIzinDanSakit']);
            Route::get('/izin-sakit-guru/{id}/batalkan', [PresensiController::class, 'batalkanIzinDanSakit']);
        });
    });
});
