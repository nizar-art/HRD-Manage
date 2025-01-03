<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormProfile extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $karyawan = Karyawan::where('user_id', $userId)->first();
        $karyawanId = $karyawan ? $karyawan->id : null;

        // Fetch data provinsi dari API eksternal
        $response = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json');
        $provinsis = $response->successful() ? $response->json() : [];

        $pageConfigs = ['myLayout' => 'front'];
        if (empty($provinsis)) {
          session()->flash('error', 'Gagal mengambil data provinsi.');
      }
      

        return view('content.Karyawan.form-profile-karyawan', [
            'pageConfigs' => $pageConfigs,
            'karyawanId' => $karyawanId,
           'provinsis' => $provinsis,
        ]);
    }
}