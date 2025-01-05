<?php

namespace App\Http\Controllers\hrd;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Kepegawaian;
use App\Models\KontrakKerja;
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
    $totalUsers = User::count();
    $totalKaryawan = Karyawan::count();
    $totalKepegawaian = Kepegawaian::count();
    $totalKontrakKerja = KontrakKerja::count();

    return view('content.hrd.profile-karyawan-list',[
      'provinsis' => $provinsis,
      'totalUsers' => $totalUsers,
      'totalKaryawan' => $totalKaryawan,
      'totalKepegawaian' => $totalKepegawaian,
      'totalKontrakKerja' => $totalKontrakKerja,
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
            'tanggal_lahir' => $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('d-m-Y') : null,
            'email' => $karyawan->email,
            'nomor_hp' => $karyawan->nomor_hp
        ];
    });

    return response()->json([
        'data' => $formattedData
    ]);
  }

  public function delete($id)
  {
      // Cari karyawan berdasarkan ID
      $karyawan = Karyawan::find($id);

      // Jika karyawan tidak ditemukan, kembalikan pesan error
      if (!$karyawan) {
          return response()->json([
              'status' => 'error',
              'message' => 'Karyawan tidak ditemukan'
          ], 404);
      }

      // Hapus karyawan
      $karyawan->delete();

      // Kembalikan response sukses
      return response()->json([
          'status' => 'success',
          'message' => 'Karyawan berhasil dihapus'
      ]);
  }


}
