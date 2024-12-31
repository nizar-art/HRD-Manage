<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\Kepegawaian;
use App\Models\RiwayatPendidikan;
use App\Models\Keluarga;
use App\Models\HistoryKontrak;

class ViewKaryawan extends Controller
{
    public function index()
    {
        // Ambil user_id dari pengguna yang sedang login
        $userId = Auth::id();

        // Ambil data karyawan berdasarkan user_id
        $dataPribadi = Karyawan::where('user_id', $userId)->first();

        // Jika data karyawan tidak ditemukan, arahkan ke halaman profil tidak lengkap
        if (!$dataPribadi) {
            $pageConfigs = ['myLayout' => 'front'];
            return view('content.Karyawan.incomplete-profile', [
                'pageConfigs' => $pageConfigs
            ]);
        }

        // Ambil id_karyawan dari dataPribadi
        $idKaryawan = $dataPribadi->id;

        // Ambil data terkait karyawan
        $dataPendidikan = RiwayatPendidikan::where('id_karyawan', $idKaryawan)->get(); // Koleksi pendidikan
        $dataKeluarga = Keluarga::where('id_karyawan', $idKaryawan)->first(); // Data keluarga (single record)
        $dataKepegawaian = Kepegawaian::where('id_karyawan', $idKaryawan)->first(); // Data kepegawaian
        $dataHistoryKontrak = HistoryKontrak::where('id_kontrak_kerja', $idKaryawan)->get();

        $pageConfigs = ['myLayout' => 'front'];

        // Tampilkan halaman detail karyawan dengan data yang lengkap
        return view('content.Karyawan.view-karyawan', [
            'pageConfigs' => $pageConfigs,
            'dataPribadi' => $dataPribadi,
            'dataPendidikan' => $dataPendidikan, // Koleksi data pendidikan
            'dataKeluarga' => $dataKeluarga,
            'dataKepegawaian' => $dataKepegawaian,
            'dataHistoryKontrak' => $dataHistoryKontrak,
        ]);
    }
}
