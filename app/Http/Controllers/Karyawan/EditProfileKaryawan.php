<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use Illuminate\Http\Request;

class EditProfileKaryawan extends Controller
{
    public function index()
    {
      $pageConfigs = ['myLayout' => 'front'];

       // Ambil data provinsi
      $provinsis = Provinces::all();

      return view('content.Karyawan.edit-profile-karyawan',[
            'pageConfigs' => $pageConfigs,
            'provinsis' => $provinsis,
        ]);
    }
    public function edit($userId)
    {
        $karyawan = Karyawan::where('user_id', $userId)->firstOrFail();
        $provinsis = Provinces::all();

        $parseAlamat = function ($alamat) {
            $parts = explode(', ', $alamat);
            $parsed = [];
            foreach ($parts as $part) {
                if (preg_match('/^(RT|RW) (\d+)/', $part, $matches)) {
                    $parsed[strtolower($matches[1])] = $matches[2];
                } elseif (preg_match('/^(Desa|Kecamatan|Kabupaten|Provinsi) (.+)$/', $part, $matches)) {
                    $parsed[strtolower($matches[1])] = $matches[2];
                } else {
                    $parsed['jalan'] = $part;
                }
            }
            return $parsed;
        };

        $alamatKtp = $parseAlamat($karyawan->alamat_ktp);
        $alamatDomisili = $karyawan->alamat_domisili ? $parseAlamat($karyawan->alamat_domisili) : null;

        return view('content.Karyawan.edit-profile-karyawan', [
            'karyawan' => $karyawan,
            'provinsis' => $provinsis,
            'alamat_ktp' => $alamatKtp,
            'alamat_domisili' => $alamatDomisili,
        ]);
    }


  public function update(Request $request, $userId)
  {
      // Cari karyawan berdasarkan user_id
      $karyawan = Karyawan::where('user_id', $userId)->firstOrFail();

      // Validasi data masukan
      $request->validate([
          'nama_lengkap' => 'required|string|max:255',
          'jenis_kelamin' => 'required|string|in:L,P',
          'tempat_lahir' => 'required|string|max:255',
          'tanggal_lahir' => 'required|date',
          'alamat_ktp' => 'required|array',
          'alamat_ktp.jalan' => 'required|string|max:255',
          'alamat_ktp.rt' => 'required|string|max:3',
          'alamat_ktp.rw' => 'required|string|max:3',
          'alamat_ktp.provinsi' => 'required|string|max:255',
          'alamat_ktp.kabupaten' => 'required|string|max:255',
          'alamat_ktp.kecamatan' => 'required|string|max:255',
          'alamat_ktp.desa' => 'required|string|max:255',
          'alamat_domisili' => 'nullable|array',
          'alamat_domisili.jalan' => 'nullable|string|max:255',
          'alamat_domisili.rt' => 'nullable|string|max:3',
          'alamat_domisili.rw' => 'nullable|string|max:3',
          'alamat_domisili.provinsi' => 'nullable|string|max:255',
          'alamat_domisili.kabupaten' => 'nullable|string|max:255',
          'alamat_domisili.kecamatan' => 'nullable|string|max:255',
          'alamat_domisili.desa' => 'nullable|string|max:255',
          'email' => 'required|email',
          'agama' => 'nullable|string|max:255',
          'nomor_nik_ktp' => 'required|string|max:16',
          'nomor_hp' => 'nullable|string|max:15',
          'golongan_darah' => 'nullable|string|max:3',
          'ibu_kandung' => 'nullable|string|max:255',
          'status_pernikahan' => 'nullable|string|max:255',
      ]);

      // Salin data alamat domisili dari KTP jika kosong
      $alamatDomisili = $request->input('alamat_domisili', $request->input('alamat_ktp'));

      $formatAlamat = function ($alamat) {
          return "{$alamat['jalan']}, RT {$alamat['rt']}/RW {$alamat['rw']}, Desa {$alamat['desa']}, Kecamatan {$alamat['kecamatan']}, Kabupaten {$alamat['kabupaten']}, Provinsi {$alamat['provinsi']}";
      };

      $alamatKtp = $formatAlamat($request->input('alamat_ktp'));
      $alamatDomisili = $formatAlamat($alamatDomisili);

      // Perbarui data karyawan
      $karyawan->update([
          'nama_lengkap' => $request->input('nama_lengkap'),
          'jenis_kelamin' => $request->input('jenis_kelamin'),
          'tempat_lahir' => $request->input('tempat_lahir'),
          'tanggal_lahir' => $request->input('tanggal_lahir'),
          'alamat_ktp' => $alamatKtp,
          'alamat_domisili' => $alamatDomisili,
          'email' => $request->input('email'),
          'agama' => $request->input('agama'),
          'nomor_nik_ktp' => $request->input('nomor_nik_ktp'),
          'nomor_hp' => $request->input('nomor_hp'),
          'golongan_darah' => $request->input('golongan_darah'),
          'ibu_kandung' => $request->input('ibu_kandung'),
          'status_pernikahan' => $request->input('status_pernikahan'),
      ]);

      return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $karyawan], 200);
  }
  public function getKabupatenedit(Request $request)
    {
        $kabupatens = Regencies::where('province_id', $request->provinsi_id)->get();
        return response()->json($kabupatens);
    }

    public function getKecamatanedit(Request $request)
    {
        $kecamatans = Districts::where('regency_id', $request->kabupaten_id)->get();
        return response()->json($kecamatans);
    }

    public function getDesaedit(Request $request)
    {
        $desas = Villages::where('district_id', $request->kecamatan_id)->get();
        return response()->json($desas);
    }
}
