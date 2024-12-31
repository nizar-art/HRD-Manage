<?php

namespace App\Http\Controllers\hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kepegawaian;
use App\Models\RiwayatPendidikan;
use App\Models\Keluarga;
use App\Models\HistoryKontrak;

class DetailKaryawan extends Controller
{
  public function index($id)
  {
      // Mengambil semua data keluarga, bukan hanya satu
      $dataKeluarga = Keluarga::where('id_karyawan', $id)->get(); // Menggunakan get() untuk koleksi

      // Ambil data lainnya
      $dataPribadi = Karyawan::where('id', $id)->first();
      $dataPendidikan = RiwayatPendidikan::where('id_karyawan', $id)->get();
      $dataKepegawaian = Kepegawaian::where('id_karyawan', $id)->first();
      $dataHistoryKontrak = HistoryKontrak::where('id_kontrak_kerja', $id)->get(); // Use 'id_karyawan' here

      // Tampilkan view
      return view('content.hrd.detail-karyawan', [
          'dataPribadi' => $dataPribadi,
          'dataPendidikan' => $dataPendidikan,
          'dataKeluarga' => $dataKeluarga,
          'dataKepegawaian' => $dataKepegawaian,
          'dataHistoryKontrak' => $dataHistoryKontrak,
      ]);
  }

}
