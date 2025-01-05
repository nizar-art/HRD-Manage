<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Kepegawaian;
use App\Models\KontrakKerja;
use Illuminate\Http\Request;

class LogisticsDashboard extends Controller
{
    public function index()
    {
        // Menghitung total data
        $totalUsers = User::count();
        $totalKaryawan = Karyawan::count();
        $totalKepegawaian = Kepegawaian::count();
        $totalKontrakKerja = KontrakKerja::count();

        // Menghitung jumlah karyawan yang bekerja di perusahaan LKI
        $totalKaryawanLKI = Kepegawaian::where('perusahaan', 'LKI')->count();

        // Menghitung jumlah karyawan yang bekerja di perusahaan Green Cold
        $totalKaryawanGreenCold = Kepegawaian::where('perusahaan', 'Green Cold')->count();

        // Menghitung persentase karyawan yang bekerja di perusahaan LKI
        $persenLKI = $totalKepegawaian > 0 ? ($totalKaryawanLKI / $totalKepegawaian) * 100 : 0;

        // Menghitung persentase karyawan yang bekerja di perusahaan Green Cold
        $persenGreenCold = $totalKepegawaian > 0 ? ($totalKaryawanGreenCold / $totalKepegawaian) * 100 : 0;

        // Mengirim data ke view
        return view('content.apps.app-logistics-dashboard', [
            'totalUsers' => $totalUsers,
            'totalKaryawan' => $totalKaryawan,
            'totalKepegawaian' => $totalKepegawaian,
            'totalKontrakKerja' => $totalKontrakKerja,
            'persenLKI' => $persenLKI,
            'persenGreenCold' => $persenGreenCold,
            'totalKaryawanLKI' => $totalKaryawanLKI,
            'totalKaryawanGreenCold' => $totalKaryawanGreenCold,
        ]);
    }
}
