<?php

namespace App\Http\Controllers\hrd;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use Illuminate\Http\Request;

class ProfileKaryawanList extends Controller
{
  public function index()
  {
    $provinsis = Provinces::all();

    return view('content.hrd.profile-karyawan-list',[
      'provinsis' => $provinsis,
  ]);
  }
  public function getProfileKaryawan()
  {
    $karyawans = Karyawan::select('id', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'email', 'nomor_hp')->get();

    $formattedData = $karyawans->map(function ($karyawan) {
        return [
            'id' => $karyawan->id,
            'nama_lengkap' => ucfirst($karyawan->nama_lengkap),
            'jenis_kelamin' => $karyawan->jenis_kelamin,
            'tempat_lahir' => ucfirst($karyawan->tempat_lahir),
            'tanggal_lahir' => $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('Y-m-d') : null,
            'email' => $karyawan->email,
            'nomor_hp' => $karyawan->nomor_hp
        ];
    });

    return response()->json([
        'data' => $formattedData
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

      return response()->json([
          'karyawan' => $karyawan,
          'provinsis' => $provinsis,
          'alamat_ktp' => $alamatKtp,
          'alamat_domisili' => $alamatDomisili,
      ]);
  }

}
