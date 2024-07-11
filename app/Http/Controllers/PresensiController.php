<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PresensiController extends Controller
{
    public function create()
    {
        $hari_ini = date("Y-m-d");
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
        $check = DB::table('presensi')->where('tanggal_presensi', $hari_ini)->where('nuptk', $nuptk)->count();
        return view('presensi.buat_presensi_karyawan', compact('check'));
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
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
        $tanggal_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        $latitude_kantor = -6.410222;
        $longitude_kantor = 106.720293;

        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitude_user = $lokasi_user[0];
        $longitude_user = $lokasi_user[1];

        $jarak = $this->distance($latitude_kantor, $longitude_kantor, $latitude_user, $longitude_user);
        $radius = round($jarak["meters"]);

        $check = DB::table('presensi')->where('tanggal_presensi', $tanggal_presensi)->where('nuptk', $nuptk)->count();
        $image = $request->image;
        $directory_path = "public/uploads/presensi/";
        $format_name = $nuptk . "-" . $tanggal_presensi;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);

        if ($radius > 5) {
            return response()->json([
                'status' => 'error',
                'message' => "Maaf, Anda Berada Di Luar Radius, Jarak Anda " . $radius . " meter dari Kantor",
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

    // public function editProfile()
    // {
    //     $karyawan = auth()->user();
    //     return view('presensi.perbarui_profil_karyawan', compact('karyawan'));
    // }

    // public function perbaruiProfile(Request $request, $nuptk)
    // {
    //     $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();

    //     if (!$karyawan) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Karyawan tidak ditemukan.'
    //         ], 404);
    //     }

    //     $rules = [
    //         'nama_lengkap' => 'sometimes|required|string|max:100',
    //         'nomor_hp' => 'sometimes|required|numeric|digits_between:10,13',
    //         'password' => 'sometimes|required|string|min:8',
    //         'foto' => 'sometimes|required|image|mimes:jpeg,jpg,png|max:2048',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $data = [];
    //     $updatedFields = [];

    //     foreach ($rules as $field => $rule) {
    //         if ($request->has($field)) {
    //             if ($field === 'password') {
    //                 $data[$field] = Hash::make($request->$field);
    //             } elseif ($field === 'foto') {
    //                 $foto = $nuptk . '.' . $request->file('foto')->getClientOriginalExtension();
    //                 $folderPath = "uploads/karyawan";
    //                 if ($karyawan->foto) {
    //                     Storage::disk('public')->delete($folderPath . '/' . $karyawan->foto);
    //                 }
    //                 $request->file('foto')->storeAs($folderPath, $foto, 'public');
    //                 $data[$field] = $foto;
    //             } else {
    //                 $data[$field] = $request->$field;
    //             }
    //             $updatedFields[] = $field;
    //         }
    //     }

    //     if (!empty($data)) {
    //         $update = DB::table('karyawan')->where('nuptk', $nuptk)->update($data);

    //         if ($update) {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'Profil berhasil diperbarui: ' . implode(', ', $updatedFields),
    //                 'reload' => in_array('foto', $updatedFields)
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal memperbarui profil.'
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Tidak ada perubahan yang dilakukan.'
    //         ], 400);
    //     }
    // }

    public function editProfile()
    {
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
        $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();
        return view('presensi.perbarui_profil_karyawan', compact('karyawan', 'nuptk'));
    }

    // public function perbaruiProfile(Request $request, $nuptk)
    // {
    //     $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();

    //     if (!$karyawan) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Karyawan tidak ditemukan.'
    //         ], 404);
    //     }

    //     $rules = [
    //         'nama_lengkap' => 'sometimes|required|string|max:100|alpha_num',
    //         'nomor_hp' => 'sometimes|required|numeric|digits_between:10,13',
    //         'password' => 'sometimes|required|string|min:8',
    //         'foto' => 'sometimes|required|image|mimes:jpeg,jpg,png|max:2048',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'There are incorrect values in the form!',
    //                 'errors' => $validator->errors()->toArray()
    //             ], 422);
    //         }

    //         throw ValidationException::withMessages($validator->errors()->toArray());
    //     }

    //     // Simulate update operation
    //     // Replace with your actual update logic
    //     $updateSuccess = true;

    //     if ($updateSuccess) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Profil berhasil diperbarui.'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal memperbarui profil. Silakan coba lagi.'
    //         ], 500);
    //     }
    // }

    public function perbaruiProfile(Request $request, $nuptk)
    {
        $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();

        if (!$karyawan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan.'
            ], 404);
        }

        $rules = [
            'nama_lengkap' => 'sometimes|required|string|max:100|regex:/^[a-zA-Z0-9\s]+$/',
            'nomor_hp' => 'sometimes|required|numeric|digits_between:10,13',
            'password' => 'sometimes|nullable|string|min:8',
            'foto' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];

        $messages = [
            'nama_lengkap.max' => 'Nama maksimal 100 karakter.',
            'nama_lengkap.regex' => 'Nama hanya boleh mengandung huruf, angka, dan spasi.',
            'nomor_hp.digits_between' => 'Nomor handphone harus antara 10 sampai 13 digit.',
            'nomor_hp.numeric' => 'Nomor handphone hanya boleh berisi angka.',
            'password.min' => 'Password minimal 8 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang diterima: jpeg, jpg, png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ada kesalahan dalam formulir!',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // Update logic
        $data = $request->only(['nama_lengkap', 'nomor_hp']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        if ($request->hasFile('foto')) {
            // Handle file upload
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/foto', $filename);
            $data['foto'] = $filename;
        }

        try {
            DB::table('karyawan')->where('nuptk', $nuptk)->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui profil. Silakan coba lagi.'
            ], 500);
        }
    }


    public function riwayat()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.riwayat_presensi_karyawan', compact('nama_bulan'));
    }

    public function dapatkanRiwayat(Request $request)
    {
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
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
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
        $data_izin = DB::table('pengajuan_izin')->where('nuptk', $nuptk)->get();
        return view('presensi.izin', compact('data_izin'));
    }

    public function buatIzin()
    {
        return view('presensi.buat_izin_karyawan');
    }

    public function storeIzin(Request $request)
    {
        $nuptk = Auth::guard('karyawan')->user()->nuptk;
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
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getPresensi(Request $request)
    {
        $tanggal_presensi = $request->input('tanggal');

        $presensi = DB::table('presensi')
            ->select('presensi.*', 'karyawan.nama_lengkap', 'karyawan.jabatan')
            ->join('karyawan', 'presensi.nuptk', '=', 'karyawan.nuptk')
            ->where('presensi.tanggal_presensi', $tanggal_presensi)
            ->get();

        if ($presensi->isEmpty()) {
            return '<tr><td colspan="9">Tidak ada data presensi ditemukan untuk tanggal ini.</td></tr>';
        }

        $html = view('presensi.getpresensi', compact('presensi'))->render();
        return $html;
    }

    // public function tampilkanPeta(Request $request)
    // {
    //     $id = $request->id;

    //     $presensi = DB::table('presensi')
    //         ->join('karyawan', 'presensi.nuptk', '=', 'karyawan.nuptk')
    //         ->where('presensi.id', $id)
    //         ->first();


    //     return view('presensi.showmap', compact('presensi'));
    // }

    public function laporan()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();

        return view('presensi.laporan', compact('nama_bulan', 'karyawan'));
    }

    public function cetakLaporan(Request $request)
    {
        $nuptk = $request->nuptk;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();

        $presensi = DB::table('presensi')
            ->where('nuptk', $nuptk)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->orderBy('tanggal_presensi')
            ->get();

        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'nama_bulan', 'karyawan', 'presensi'));
    }

    public function rekap()
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.rekap', compact('nama_bulan'));
    }

    public function cetakrekap(Request $request)
    {
        $nama_bulan = [" ", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensi')
            ->selectRaw(
                'presensi.nuptk, nama_lengkap,
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
            )->join('karyawan', 'presensi.nuptk', '=', 'karyawan.nuptk')
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nuptk, nama_lengkap')
            ->get();

        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'nama_bulan', 'rekap'));
    }

    public function izinsakit()
    {
        $izinsakit = DB::table('pengajuan_izin')
            ->join('karyawan', 'pengajuan_izin.nuptk', '=', 'karyawan.nuptk')
            ->orderBy('tanggal_izin', 'desc')
            ->get();
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approve = $request->status_persetujuan;
        $id_izinsakit_form = $request->id_izinsakit_form;

        $update = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
            'status_persetujuan' => $status_approve
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di-Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di-Update']);
        }
    }


    public function batalkanizinsakit($id)
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
}
