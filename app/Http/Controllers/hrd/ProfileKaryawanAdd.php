<?php

namespace App\Http\Controllers\hrd;

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

class ProfileKaryawanAdd extends Controller
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

        return view('content.hrd.profile-karyawan-add', [
            'karyawanId' => $karyawanId,
            'provinsis' => $provinsis,
        ]);
      }
  public function storeKaryawanHrd(Request $request)
    {
      $request->validate([
          'user_id' => 'required|exists:users,id',
          'nama_lengkap' => 'required|string|max:255',
          'jenis_kelamin' => 'required|string|in:L,P',
          'tempat_lahir' => 'required|string|max:255',
          'tanggal_lahir' => 'required|date',
          'alamat_ktp' => 'required|array', // Validasi alamat KTP harus berupa array
          'alamat_ktp.jalan' => 'required|string|max:255',
          'alamat_ktp.rt' => 'required|string|max:3',
          'alamat_ktp.rw' => 'required|string|max:3',
          'alamat_ktp.provinsi' => 'required|string|max:255',
          'alamat_ktp.kabupaten' => 'required|string|max:255',
          'alamat_ktp.kecamatan' => 'required|string|max:255',
          'alamat_ktp.desa' => 'required|string|max:255',
          'alamat_domisili' => 'nullable|array', // Validasi opsional untuk alamat domisili
          'alamat_domisili.jalan' => 'nullable|string|max:255',
          'alamat_domisili.rt' => 'nullable|string|max:3',
          'alamat_domisili.rw' => 'nullable|string|max:3',
          'alamat_domisili.provinsi' => 'nullable|string|max:255',
          'alamat_domisili.kabupaten' => 'nullable|string|max:255',
          'alamat_domisili.kecamatan' => 'nullable|string|max:255',
          'alamat_domisili.desa' => 'nullable|string|max:255',
          'email' => 'required|email|unique:karyawan,email',
          'agama' => 'required|string|max:50',
          'nomor_nik_ktp' => 'required|string|max:16|unique:karyawan,nomor_nik_ktp',
          'nomor_npwp' => 'nullable|string|max:15',
          'nomor_hp' => 'required|string|max:15',
          'golongan_darah' => 'required|string|in:A,B,AB,O',
          'ibu_kandung' => 'required|string|max:255',
          'status_pernikahan' => 'required|string|in:Belum Menikah,Menikah,Cerai',
      ]);

      // Format alamat KTP dan domisili menggunakan array_map
      $formatAlamat = function ($alamat) {
          return "{$alamat['jalan']}, RT {$alamat['rt']}/RW {$alamat['rw']}, Desa {$alamat['desa']}, Kecamatan {$alamat['kecamatan']}, Kabupaten {$alamat['kabupaten']}, Provinsi {$alamat['provinsi']}";
      };

      $alamatKtp = $formatAlamat($request->input('alamat_ktp'));
      $alamatDomisili = $request->has('alamat_domisili') ? $formatAlamat($request->input('alamat_domisili')) : null;

      // Simpan data karyawan
      $karyawan = Karyawan::create([
          'user_id' => $request->input('user_id'),
          'nama_lengkap' => $request->input('nama_lengkap'),
          'jenis_kelamin' => $request->input('jenis_kelamin'),
          'tempat_lahir' => $request->input('tempat_lahir'),
          'tanggal_lahir' => $request->input('tanggal_lahir'),
          'alamat_ktp' => $alamatKtp, // Menyimpan alamat KTP terformat
          'alamat_domisili' => $alamatDomisili, // Menyimpan alamat domisili terformat
          'email' => $request->input('email'),
          'agama' => $request->input('agama'),
          'nomor_nik_ktp' => $request->input('nomor_nik_ktp'),
          'nomor_npwp' => $request->input('nomor_npwp'),
          'nomor_hp' => $request->input('nomor_hp'),
          'golongan_darah' => $request->input('golongan_darah'),
          'ibu_kandung' => $request->input('ibu_kandung'),
          'status_pernikahan' => $request->input('status_pernikahan'),
      ]);

      return response()->json(['message' => 'Data Karyawan berhasil disimpan', 'data' => $karyawan], 201);
  }
  // Store data for Riwayat Pendidikan
  public function storeRiwayatPendidikanHrd(Request $request)
  {
      $request->validate([
          'id' => 'nullable|exists:riwayat_pendidikan,id', // ID riwayat pendidikan (untuk delete/update)
          'id_karyawan' => 'required|exists:karyawan,id',
          'jenjang' => 'required|string|max:50',
          'nama_sekolah' => 'required|string|max:255',
          'jurusan' => 'nullable|string|max:100',
          'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
          'delete' => 'nullable|boolean', // Parameter untuk menentukan hapus
      ]);

      // Jika parameter `delete` ada dan bernilai true, lakukan penghapusan
      if ($request->has('delete') && $request->delete) {
          // Cari berdasarkan ID
          $riwayatPendidikan = RiwayatPendidikan::find($request->id);

          if ($riwayatPendidikan) {
              $riwayatPendidikan->delete();
              return response()->json(['success' => 'Riwayat Pendidikan berhasil dihapus'], 200);
          } else {
              return response()->json(['error' => 'Riwayat Pendidikan tidak ditemukan untuk dihapus'], 404);
          }
      }

      // Proses simpan atau update
      $riwayatPendidikan = RiwayatPendidikan::where('id_karyawan', $request->id_karyawan)
          ->where('jenjang', $request->jenjang)
          ->first();

      if ($riwayatPendidikan) {
          // Jika sudah ada, lakukan update
          $riwayatPendidikan->update([
              'jenjang' => $request->jenjang,
              'nama_sekolah' => $request->nama_sekolah,
              'jurusan' => $request->jurusan,
              'tahun_lulus' => $request->tahun_lulus,
          ]);

          return response()->json(['success' => 'Riwayat Pendidikan berhasil diperbarui', 'data' => $riwayatPendidikan], 200);
      } else {
          // Jika belum ada, buat data baru
          $newRiwayatPendidikan = RiwayatPendidikan::create($request->only([
              'id_karyawan',
              'jenjang',
              'nama_sekolah',
              'jurusan',
              'tahun_lulus',
          ]));

          return response()->json(['message' => 'Riwayat Pendidikan berhasil disimpan', 'data' => $newRiwayatPendidikan], 201);
      }

  }

  // Store data for Keluarga
  public function storeKeluargaHrd(Request $request)
  {
      $request->validate([
          'id' => 'nullable|exists:keluarga,id', // ID keluarga (untuk delete/update)
          'id_karyawan' => 'required|exists:karyawan,id',
          'status' => 'required|string|max:50',
          'nama_lengkap' => 'required|string|max:255',
          'nomer_hp' => 'nullable|string|max:15',
          'delete' => 'nullable|boolean', // Parameter untuk menentukan hapus
      ]);

      // Jika parameter `delete` ada dan bernilai true, lakukan penghapusan
      if ($request->has('delete') && $request->delete) {
          // Cari berdasarkan ID
          $keluarga = Keluarga::find($request->id);

          if ($keluarga) {
              $keluarga->delete();
              return response()->json(['success' => 'Data Keluarga berhasil dihapus'], 200);
          } else {
              return response()->json(['error' => 'Data Keluarga tidak ditemukan untuk dihapus'], 404);
          }
      }

      // Proses simpan atau update
      $keluarga = Keluarga::where('id_karyawan', $request->id_karyawan)
          ->where('status', $request->status)
          ->first();

      if ($keluarga) {
          // Jika sudah ada, lakukan update
          $keluarga->update([
              'status' => $request->status,
              'nama_lengkap' => $request->nama_lengkap,
              'nomer_hp' => $request->nomer_hp,
          ]);

          return response()->json(['success' => 'Data Keluarga berhasil diperbarui', 'data' => $keluarga], 200);
      } else {
          // Jika belum ada, buat data baru
          $newKeluarga = Keluarga::create($request->only([
              'id_karyawan',
              'status',
              'nama_lengkap',
              'nomer_hp',
          ]));

          return response()->json(['message' => 'Data Keluarga berhasil disimpan', 'data' => $newKeluarga], 201);
      }
  }
}
