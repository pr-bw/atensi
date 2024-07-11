<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hari_ini = date("Y-m-d");
        $bulan_ini = date("m") * 1;
        $tahun_ini = date("Y");
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
        $presensi_hari_ini = DB::table('presensi')->where('nuptk', $nuptk)->where('tanggal_presensi', $hari_ini)->first();
        $history_bulan_ini = DB::table('presensi')->where('nuptk', $nuptk)->whereRaw('MONTH(tanggal_presensi)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun_ini . '"')
            ->orderBy('tanggal_presensi')
            ->get();

        $rekap_presensi = DB::table('presensi')
            ->selectRaw('COUNT(nuptk) as jumlah_hadir, SUM(IF(jam_in > "07:30", 1, 0)) as jumlah_terlambat')
            ->where('nuptk', $nuptk)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun_ini . '"')
            ->first();

        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nuptk', '=', 'karyawan.nuptk')
            ->where('tanggal_presensi', $hari_ini)
            ->orderBy('jam_in')
            ->get();

        $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekap_izin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jumlah_izin, SUM(IF(status="s",1,0)) as jumlah_sakit')
            ->where('nuptk', $nuptk)
            ->whereRaw('MONTH(tanggal_izin) = "' . $bulan_ini . '"')
            ->whereRaw('YEAR(tanggal_izin) = "' . $tahun_ini . '"')
            ->where('status_persetujuan', 1)
            ->first();

        return view('dashboard.dashboard_karyawan', compact('presensi_hari_ini', 'history_bulan_ini', 'nama_bulan', 'bulan_ini', 'tahun_ini', 'rekap_presensi', 'leaderboard', 'rekap_izin'));
    }

    public function dashboardAdmin()
    {
        $hari_ini = date("Y-m-d");

        $rekap_presensi = DB::table('presensi')
            ->selectRaw('COUNT(nuptk) as jumlah_hadir, SUM(IF(jam_in > "07:30", 1, 0)) as jumlah_terlambat')
            ->where('tanggal_presensi', $hari_ini)
            ->first();

        $rekap_izin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i", 1, 0)) as jumlah_izin, SUM(IF(status="s", 1, 0)) as jumlah_sakit')
            ->where('tanggal_izin', $hari_ini)
            ->where('status_persetujuan', 1)
            ->first();

        return view('dashboard.dashboardadmin', compact('rekap_presensi', 'rekap_izin'));
    }
}
