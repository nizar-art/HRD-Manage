<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

use Illuminate\Http\Request;

class EditPendidikanKaryawan extends Controller
{
  public function index()
  {
     // Ambil user ID yang sedang login
     $userId = Auth::id();

     // Cari data karyawan yang terkait dengan user ID tersebut
     $karyawan = Karyawan::where('user_id', $userId)->first();

     // Ambil ID karyawan jika ditemukan
     $karyawanId = $karyawan ? $karyawan->id : null;

     $pageConfigs = ['myLayout' => 'front'];

    return view('content.Karyawan.edit-pendidikan-karyawan',['pageConfigs' => $pageConfigs],compact('karyawanId'));
  }
}
