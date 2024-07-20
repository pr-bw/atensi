<?php

namespace App\Http\Controllers;

use App\Exports\RekapPresensiExport;
use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function create()
    {
        $hari_ini = date("Y-m-d");
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $check = DB::table('presensi')->where('tanggal_presensi', $hari_ini)->where('nuptk', $nuptk)->count();
        $loc_sekolah = DB::table('konfigurasi_lokasi_sekolah')->where('id', 1)->first();
        return view('presensi.buat_presensi_guru', compact('check', 'loc_sekolah'));
    }

    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function simpanPresensi(Request $request)
    {
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $tanggal_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $loc_sekolah = DB::table('konfigurasi_lokasi_sekolah')->where('id', 1)->first();
        $loc = explode(",", $loc_sekolah->lokasi_sekolah);
        $latitude_sekolah = $loc[0];
        $longitude_sekolah = $loc[1];

        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitude_user = $lokasi_user[0];
        $longitude_user = $lokasi_user[1];

        $jarak = $this->distance($latitude_sekolah, $longitude_sekolah, $latitude_user, $longitude_user);
        $radius = round($jarak["meters"]);

        $check = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nuptk', $nuptk)->count();
        $image = $request->image;
        $directory_path = "public/uploads/presensi/";
        $format_name = $nuptk . "-" . $tanggal_presensi;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);

        if ($radius > $loc_sekolah->radius) {
            return response()->json([
                'status' => 'error',
                'message' => "Maaf, Anda Berada Di Luar Radius, Jarak Anda " . $radius . " meter dari sekolah",
                'type' => 'radius'
            ]);
        } else {
            if ($check > 0) {
                $file_name = $format_name . "_pulang.png";
            } else {
                $file_name = $format_name . "_masuk.png";
            }

            $file = $directory_path . $file_name;

            if ($check > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $file_name,
                    'lokasi_out' => $lokasi,
                ];

                $update = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nuptk', $nuptk)->update($data_pulang);

                if ($update) {
                    Storage::put($file, $image_base64);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Terima Kasih, Hati-Hati Di Jalan',
                        'type' => 'out'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal Melakukan Presensi',
                        'type' => 'out'
                    ]);
                }
            } else {
                $data = [
                    'nuptk' => $nuptk,
                    'tanggal_presensi' => $tanggal_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $file_name,
                    'lokasi_in' => $lokasi,
                ];

                $simpan = DB::table('presensi')->insert($data);

                if ($simpan) {
                    Storage::put($file, $image_base64);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Terima Kasih, Selamat Bekerja',
                        'type' => 'in'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal Melakukan Presensi',
                        'type' => 'in'
                    ]);
                }
            }
        }
    }

    public function editProfile()
    {
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $guru = DB::table('guru')->where('nuptk', $nuptk)->first();
        return view('presensi.perbarui_profil_guru', compact('guru', 'nuptk'));
    }

    public function perbaruiProfile(Request $request, $nuptk)
    {
        // Fetch the guru record
        $guru = DB::table('guru')->where('nuptk', $nuptk)->first();

        // If guru not found, return error response
        if (!$guru) {
            return redirect()->back()->with('error', 'guru tidak ditemukan.');
        }

        // Define validation rules and custom error messages
        $rules = [
            'nomor_hp' => 'nullable|numeric|digits_between:10,13',
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];

        $messages = [
            'nomor_hp.digits_between' => 'Nomor handphone harus antara 10 sampai 13 digit.',
            'nomor_hp.numeric' => 'Nomor handphone hanya boleh berisi angka.',
            'password.min' => 'Password minimal 8 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang diterima: jpeg, jpg, png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return to the form with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare data to be updated
        $data = [];
        $updatedFields = [];

        if ($request->filled('nomor_hp') && $request->nomor_hp !== $guru->nomor_hp) {
            $data['nomor_hp'] = $request->input('nomor_hp');
            $updatedFields[] = 'Nomor HP';
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
            $updatedFields[] = 'Password';
        }

        if ($request->hasFile('foto')) {
            $foto = $nuptk . '.' . $request->file('foto')->getClientOriginalExtension();
            $folderPath = "uploads/guru";
            $request->file('foto')->storeAs($folderPath, $foto, 'public');
            $data['foto'] = $foto;
            $updatedFields[] = 'Foto Profile';
        }

        if (empty($data)) {
            return redirect()->back()->with('warning', 'Tidak ada data yang diperbarui.');
        }

        try {
            // Update the guru record
            DB::table('guru')->where('nuptk', $nuptk)->update($data);

            // Prepare success message
            $successMessage = 'Profil berhasil diperbarui. Data yang diperbarui: ' . implode(', ', $updatedFields) . '.';

            // Return success response
            return redirect()->back()->with('success', $successMessage);
        } catch (\Exception $e) {
            // Return error response in case of any exception
            return redirect()->back()->with('error', 'Gagal memperbarui profil. Silakan coba lagi.');
        }
    }

    public function riwayat()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.riwayat_presensi_guru', compact('nama_bulan'));
    }

    public function dapatkanRiwayat(Request $request)
    {
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // get the history of presensi for the specified month and year
        $history = DB::table('presensi')
            ->whereRaw('MONTH(tanggal_presensi) = "' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi) = "' . $tahun . '"')
            ->where('nuptk', $nuptk)
            ->orderBy('tanggal_presensi')
            ->get();

        return view('presensi.gethistory', compact('history'));
    }

    public function listIzin()
    {
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $data_izin = DB::table('pengajuan_izin')->where('nuptk', $nuptk)->get();
        return view('presensi.izin', compact('data_izin'));
    }

    public function buatIzin()
    {
        return view('presensi.buat_izin_guru');
    }

    public function simpanIzin(Request $request)
    {
        $nuptk = Auth::guard('guru')->user()->nuptk;
        $tanggal_izin = $request->tanggal_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nuptk' => $nuptk,
            'tanggal_izin' => $tanggal_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/guru/izin/buat-izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/guru/izin/buat-izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function monitoringPresensi()
    {
        return view('presensi.monitoring_presensi');
    }

    public function tampilkanRekapPresensiHarian(Request $request)
    {
        $tanggal_presensi = $request->input('tanggal');

        $presensi = DB::table('presensi')
            ->select('presensi.*', 'guru.nama_lengkap', 'guru.mapel')
            ->join('guru', 'presensi.nuptk', '=', 'guru.nuptk')
            ->where('presensi.tanggal_presensi', $tanggal_presensi)
            ->get();

        if ($presensi->isEmpty()) {
            return '<tr><td colspan="9">Tidak ada data presensi ditemukan untuk tanggal ini.</td></tr>';
        }

        return view('presensi.tampilkan-rekap-presensi-harian', compact('presensi'));
    }


    // public function tampilkanPeta(Request $request)
    // {
    //     $id = $request->id;

    //     $presensi = DB::table('presensi')
    //         ->join('guru', 'presensi.nuptk', '=', 'guru.nuptk')
    //         ->where('presensi.id', $id)
    //         ->first();


    //     return view('presensi.showmap', compact('presensi'));
    // }

    public function laporanPresensi()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $guru = DB::table('guru')->orderBy('nama_lengkap')->get();

        return view('presensi.laporan-guru', compact('nama_bulan', 'guru'));
    }

    public function cetakLaporanPresensi(Request $request)
    {
        $nuptk = $request->nuptk;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $guru = DB::table('guru')->where('nuptk', $nuptk)->first();

        $presensi = DB::table('presensi')
            ->where('nuptk', $nuptk)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->orderBy('tanggal_presensi')
            ->get();

        return view('presensi.cetak_laporan_presensi', compact('bulan', 'tahun', 'nama_bulan', 'guru', 'presensi'));
    }

    // public function exportToPDF(Request $request)
    // {
    //     $nuptk = $request->nuptk;
    //     $bulan = $request->bulan;
    //     $tahun = $request->tahun;

    //     $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    //     $guru = DB::table('guru')->where('nuptk', $nuptk)->first();

    //     $presensi = DB::table('presensi')
    //         ->where('nuptk', $nuptk)
    //         ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
    //         ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
    //         ->orderBy('tanggal_presensi')
    //         ->get();

    //     // Render view to HTML
    //     $html = view('presensi.cetak_laporan_presensi', compact('bulan', 'tahun', 'nama_bulan', 'guru', 'presensi'))->render();

    //     // Configure Dompdf
    //     $options = new Options();
    //     $options->set('isHtml5ParserEnabled', true);
    //     $options->set('isPhpEnabled', true);

    //     // Instantiate Dompdf
    //     $dompdf = new Dompdf($options);

    //     // Load HTML into Dompdf
    //     $dompdf->loadHtml($html);

    //     // Set paper size and orientation (optional)
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render PDF (optional)
    //     $dompdf->render();

    //     // Output PDF to browser
    //     return $dompdf->stream("laporan_presensi.pdf");
    // }

    public function rekapitulasiPresensi()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.cetak-rekap', compact('nama_bulan'));
    }

    public function cetakRekapitulasiPresensi(Request $request)
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensi')
            ->selectRaw(
                'CAST(presensi.nuptk AS CHAR) as nuptk, nama_lengkap,
                MAX(IF(DAY(tanggal_presensi) = 1, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_1,
                MAX(IF(DAY(tanggal_presensi) = 2, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_2,
                MAX(IF(DAY(tanggal_presensi) = 3, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_3,
                MAX(IF(DAY(tanggal_presensi) = 4, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_4,
                MAX(IF(DAY(tanggal_presensi) = 5, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_5,
                MAX(IF(DAY(tanggal_presensi) = 6, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_6,
                MAX(IF(DAY(tanggal_presensi) = 7, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_7,
                MAX(IF(DAY(tanggal_presensi) = 8, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_8,
                MAX(IF(DAY(tanggal_presensi) = 9, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_9,
                MAX(IF(DAY(tanggal_presensi) = 10, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_10,
                MAX(IF(DAY(tanggal_presensi) = 11, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_11,
                MAX(IF(DAY(tanggal_presensi) = 12, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_12,
                MAX(IF(DAY(tanggal_presensi) = 13, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_13,
                MAX(IF(DAY(tanggal_presensi) = 14, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_14,
                MAX(IF(DAY(tanggal_presensi) = 15, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_15,
                MAX(IF(DAY(tanggal_presensi) = 16, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_16,
                MAX(IF(DAY(tanggal_presensi) = 17, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_17,
                MAX(IF(DAY(tanggal_presensi) = 18, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_18,
                MAX(IF(DAY(tanggal_presensi) = 19, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_19,
                MAX(IF(DAY(tanggal_presensi) = 20, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_20,
                MAX(IF(DAY(tanggal_presensi) = 21, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_21,
                MAX(IF(DAY(tanggal_presensi) = 22, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_22,
                MAX(IF(DAY(tanggal_presensi) = 23, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_23,
                MAX(IF(DAY(tanggal_presensi) = 24, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_24,
                MAX(IF(DAY(tanggal_presensi) = 25, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_25,
                MAX(IF(DAY(tanggal_presensi) = 26, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_26,
                MAX(IF(DAY(tanggal_presensi) = 27, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_27,
                MAX(IF(DAY(tanggal_presensi) = 28, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_28,
                MAX(IF(DAY(tanggal_presensi) = 29, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_29,
                MAX(IF(DAY(tanggal_presensi) = 30, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_30,
                MAX(IF(DAY(tanggal_presensi) = 31, CONCAT (jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tanggal_31'
            )->join('guru', 'presensi.nuptk', '=', 'guru.nuptk')
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nuptk, nama_lengkap')
            ->get();

        // if (isset($_POST['exportToExcel'])) {
        //     $time = date("d-M-Y H:i:s");
        //     // Fungsi header dengan mengirimkan raw data excel
        //     header("Content-type: application/vnd-ms-excel");
        //     // Mendefinisikan nama file ekspor "hasil-export.xls"
        //     header("Content-Disposition: attachment; filename=Rekap Presensi Guru $time.xls");
        // }

        if ($request->has('exportToExcel')) {
            $time = now()->format('M-Y');
            return Excel::download(
                new RekapPresensiExport($rekap, $bulan, $tahun, $nama_bulan),
                "Rekap Presensi Guru $time.xlsx"
            );
        }

        return view('presensi.cetak_rekap_presensi', compact('bulan', 'tahun', 'nama_bulan', 'rekap'));
    }

    public function izinDanSakitGuru(Request $request)
    {
        $query = PengajuanIzin::query();
        $query->select('pengajuan_izin.id', 'tanggal_izin', 'pengajuan_izin.nuptk', 'nama_lengkap', 'mapel', 'status', 'status_persetujuan', 'keterangan');
        $query->join('guru', 'pengajuan_izin.nuptk', '=', 'guru.nuptk');

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tanggal_izin', [$request->dari, $request->sampai]);
        }

        if (!empty($request->nuptk)) {
            $query->where('pengajuan_izin.nuptk', $request->nuptk);
        }

        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->status_persetujuan === '0' || $request->status_persetujuan === '1' || $request->status_persetujuan === '2') {
            $query->where('status_persetujuan', $request->status_persetujuan);
        }

        $query->orderBy('tanggal_izin', 'desc');
        $izin_dan_sakit = $query->paginate(10);
        $izin_dan_sakit->appends($request->all());

        return view('presensi.izin_dan_sakit_guru', compact('izin_dan_sakit'));
    }


    public function setujuiIzinDanSakit(Request $request)
    {
        $status_persetujuan = $request->status_persetujuan;
        $id_izin_dan_sakit_form = $request->id_izin_dan_sakit_form;

        $update = DB::table('pengajuan_izin')->where('id', $id_izin_dan_sakit_form)->update([
            'status_persetujuan' => $status_persetujuan
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di-Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di-Update']);
        }
    }


    public function batalkanIzinDanSakit($id)
    {
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_persetujuan' => 0
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di-Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di-Update']);
        }
    }

    public function cekPengajuanIzin(Request $request)
    {
        $tanggal_izin = $request->tanggal_izin;
        $nuptk = Auth::guard('guru')->user()->nuptk;

        $check = DB::table('pengajuan_izin')->where('nuptk', $nuptk)->where('tanggal_izin', $tanggal_izin)->count();
        return $check;
    }
}
