<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Karyawan;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::orderBy('nama_lengkap');

        if ($request->has('nama_karyawan') && !empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        $karyawan = $query->paginate(10);

        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nuptk' => 'required|numeric|unique:karyawan,nuptk',
            'nama_lengkap' => 'required|string|max:100',
            'pendidikan' => 'required|in:D III,D IV/S1,S2,S3',
            'jabatan' => 'required|string|max:100',
            'nomor_hp' => 'required|string|max:15|unique:karyawan,nomor_hp',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $nuptk = $request->nuptk;
        $nama_lengkap = $request->nama_lengkap;
        $pendidikan = $request->pendidikan;
        $jabatan = $request->jabatan;
        $nomor_hp = $request->nomor_hp;
        $password = Hash::make('smpislamparungok');

        // Handle file upload
        $foto = null;
        if ($request->hasFile('foto')) {
            $fotoName = $nuptk . "." . $request->file('foto')->getClientOriginalExtension();
            $fotoPath = "uploads/karyawan/";
            $request->file('foto')->storeAs($fotoPath, $fotoName);
            $foto = $fotoPath . $fotoName;
        }

        try {
            // Simpan data menggunakan model Eloquent
            $karyawan = new Karyawan();
            $karyawan->nuptk = $nuptk;
            $karyawan->nama_lengkap = $nama_lengkap;
            $karyawan->pendidikan = $pendidikan;
            $karyawan->jabatan = $jabatan;
            $karyawan->nomor_hp = $nomor_hp;
            $karyawan->foto = $foto;
            $karyawan->password = $password;
            $karyawan->save();

            return redirect()->back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $nuptk = $request->nuptk;
        $karyawan = DB::table('karyawan')->where('nuptk', $nuptk)->first();

        return view('karyawan.edit', compact('karyawan', 'nuptk'));
    }

    public function update($nuptk, Request $request)
    {
        $nuptk = $request->nuptk;
        $nama_lengkap = $request->nama_lengkap;
        $pendidikan = $request->pendidikan;
        $jabatan = $request->jabatan;
        $nomor_hp = $request->nomor_hp;
        $password = Hash::make('smpislamparungok');
        $old_foto = $request->old_foto;

        if ($request->hasFile('foto')) {
            $foto = $nuptk . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'pendidikan' => $pendidikan,
                'jabatan' => $jabatan,
                'nomor_hp' => $nomor_hp,
                'foto' => $foto,
                'password' => $password
            ];

            $update = DB::table('karyawan')->where('nuptk', $nuptk)->update($data);

            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathold = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathold);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Update']);
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }


    public function delete($nuptk)
    {
        $karyawan = Karyawan::where('nuptk', $nuptk)->first();

        if (!$karyawan) {
            return redirect()->back()->with(['warning' => 'Data Gagal Dihapus']);
        }

        try {
            Storage::delete('public/uploads/karyawan/' . $karyawan->foto);
            $delete = $karyawan->delete();

            if ($delete) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Terjadi kesalahan yang tidak terduga. Mohon coba lagi atau hubungi administrator.']);
        }
    }
}
