<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\RiwayatPendidikan;
use App\Models\Keluarga;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use Illuminate\Http\Request;

class FormProfile extends Controller
{
  public function index()
  {
    $userId = Auth::id();

    // Cari data karyawan terkait user
    $karyawan = Karyawan::where('user_id', $userId)->first();

    // Cek apakah data karyawan ditemukan
    $karyawanId = $karyawan ? $karyawan->id : null;

    // Ambil data provinsi
    $provinsis = Provinces::all();

    // Mengirimkan data ke view
    $pageConfigs = ['myLayout' => 'front'];

    return view('content.Karyawan.form-profile-karyawan',[
          'pageConfigs' => $pageConfigs,
          'karyawanId' => $karyawanId,
          'provinsis' => $provinsis,
      ]);
  }
}
