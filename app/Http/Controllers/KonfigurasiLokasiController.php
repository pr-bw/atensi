<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiLokasiController extends Controller
{
    public function lokasiSekolah()
    {
        $loc_sekolah = DB::table('konfigurasi_lokasi_sekolah')->where('id', 1)->first();
        return view('konfigurasi.lokasi_sekolah', compact('loc_sekolah'));
    }

    public function perbaruiRadiusDanLokasiSekolah(Request $request)
    {
        $lokasi_sekolah = $request->lokasi_sekolah;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasi_sekolah')->where('id', 1)->update([
            'lokasi_sekolah' => $lokasi_sekolah,
            'radius' => $radius,
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di-Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di-Update']);
        }
    }
}
