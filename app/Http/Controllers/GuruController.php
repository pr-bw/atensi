<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::orderBy('nama_lengkap');

        if ($request->has('nama_guru') && !empty($request->nama_guru)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_guru . '%');
        }

        $guru = $query->paginate(10);

        return view('guru.index', compact('guru'));
    }

    public function perbaruiDataGuru(Request $request)
    {
        $nuptk = $request->route('nuptk');
        $allowedFields = ['nuptk', 'nama_lengkap', 'jenis_kelamin', 'pendidikan', 'mapel', 'nomor_hp', 'password', 'foto'];
        $fieldNames = [
            'nuptk' => 'NUPTK',
            'nama_lengkap' => 'Nama Lengkap',
            'jenis_kelamin' => 'Jenis Kelamin',
            'pendidikan' => 'Pendidikan',
            'mapel' => 'Mata Pelajaran',
            'nomor_hp' => 'Nomor Handphone',
            'password' => 'Password',
            'foto' => 'Foto'
        ];
        $updatedFields = [];
        $failedFields = [];

        foreach ($allowedFields as $field) {
            if ($field === 'foto' && $request->hasFile('foto')) {
                try {
                    $foto = $nuptk . "." . $request->file('foto')->getClientOriginalExtension();
                    $folderPath = "public/uploads/guru/";
                    $oldFoto = DB::table('guru')->where('nuptk', $nuptk)->value('foto');
                    Storage::delete($folderPath . $oldFoto);
                    $request->file('foto')->storeAs($folderPath, $foto);
                    $update = DB::table('guru')->where('nuptk', $nuptk)->update(['foto' => $foto]);
                    if ($update) {
                        $updatedFields[] = $fieldNames[$field];
                    }
                } catch (Exception $e) {
                    $failedFields[] = $fieldNames[$field];
                }
            } elseif ($field !== 'foto' && $request->filled($field)) {
                try {
                    $value = $field === 'password' ? Hash::make($request->$field) : $request->$field;
                    $oldValue = DB::table('guru')->where('nuptk', $nuptk)->value($field);
                    if ($value !== $oldValue) {
                        $update = DB::table('guru')->where('nuptk', $nuptk)->update([$field => $value]);
                        if ($update) {
                            $updatedFields[] = $fieldNames[$field];
                        }
                    }
                } catch (Exception $e) {
                    $failedFields[] = $fieldNames[$field];
                }
            }
        }

        if (!empty($updatedFields)) {
            $successMessage = 'Data berhasil diubah: ' . implode(', ', $updatedFields);
            return Redirect::back()->with('success', $successMessage);
        } elseif (!empty($failedFields)) {
            $failMessage = 'Data gagal diubah: ' . implode(', ', $failedFields);
            return Redirect::back()->with('warning', $failMessage);
        } else {
            return Redirect::back()->with('info', 'Tidak ada data yang diubah');
        }
    }

    public function ubahDataGuru(Request $request)
    {
        $nuptk = $request->nuptk;
        $guru = DB::table('guru')->where('nuptk', $nuptk)->first();

        return view('guru.ubah-data', compact('guru', 'nuptk'));
    }

    public function tambahDataGuruDariAdministrator(Request $request)
    {
        $request->validate([
            'nuptk' => 'required|numeric|unique:guru,nuptk',
            'nama_lengkap' => 'required|string|max:100',
            'pendidikan' => 'required|in:SMA,SMK,D I,D II,D III,D IV,S1,S2,S3',
            'mapel' => 'required|string|max:100',
            'nomor_hp' => 'required|string|max:15|unique:guru,nomor_hp',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        $nuptk = $request->nuptk;
        $nama_lengkap = $request->nama_lengkap;
        $pendidikan = $request->pendidikan;
        $mapel = $request->mapel;
        $nomor_hp = $request->nomor_hp;
        $password = Hash::make('smpislamparungok');

        // Handle file upload
        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $nuptk . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/uploads/guru/'), $fileName);
            $foto = $fileName;
        }

        try {
            // Simpan data menggunakan model Eloquent
            $guru = new Guru();
            $guru->nuptk = $nuptk;
            $guru->nama_lengkap = $nama_lengkap;
            $guru->pendidikan = $pendidikan;
            $guru->mapel = $mapel;
            $guru->nomor_hp = $nomor_hp;
            $guru->foto = $foto;
            $guru->password = $password;
            $guru->save();

            if ($request->hasFile('foto')) {
                return redirect()->back()->with(['success' => 'Data Berhasil Disimpan dan Foto Berhasil Diupload']);
            } else {
                return redirect()->back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function hapusDataGuru($nuptk)
    {
        $guru = Guru::where('nuptk', $nuptk)->first();

        if (!$guru) {
            return redirect()->back()->with(['warning' => 'Data Gagal Dihapus']);
        }

        try {
            Storage::delete('public/uploads/guru/' . $guru->foto);
            $delete = $guru->delete();

            if ($delete) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
            } else {
                return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return Redirect::back()->with(['warning' => 'NUPTK atau Nomor HP sudah terdaftar']);
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }
}
