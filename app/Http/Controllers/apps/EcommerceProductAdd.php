<?php

namespace App\Http\Controllers\apps;
use Illuminate\Http\Request;
use App\models\user;
use App\Models\Karyawan;
use App\Models\Kepegawaian;
use App\Models\RiwayatPendidikan;
use App\Models\Keluarga;
use App\Http\Controllers\Controller;

class EcommerceProductAdd extends Controller
{
    // Menampilkan form
    public function index()
    {
      return view('content.hrd.profile-karyawan-add');
    }

    public function store(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'karyawan':
                return $this->storeKaryawan($request);
            case 'riwayat_pendidikan':
                return $this->storeRiwayatPendidikan($request);
            case 'keluarga':
                return $this->storeKeluarga($request);
            case 'kepegawaian':
                return $this->storeKepegawaian($request);
            default:
                return response()->json(['message' => 'Invalid type'], 400);
        }
    }

    public function storeKaryawan(Request $request)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
          'nama_lengkap' => 'required|string|max:255',
          'jenis_kelamin' => 'required|in:L,P', // L (Laki-laki), P (Perempuan)
          'tempat_lahir' => 'required|string|max:255',
          'tanggal_lahir' => 'required|date',
          'alamat_ktp' => 'required|string',
          'alamat_domisili' => 'nullable|string',
          'agama' => 'required|in:Islam,Kristen,Katolik,Konghucu,Budha,Hindu',
          'nomor_nik_ktp' => 'required|string|size:16|unique:karyawan,nomor_nik_ktp',
          'nomor_npwp' => 'nullable|string|max:15',
          'nomor_hp' => 'required|string|max:15',
          'golongan_darah' => 'nullable|string|in:A,B,AB,O',
          'ibu_kandung' => 'required|string|max:255',
          'status_pernikahan' => 'required|in:Single,Menikah,Cerai',
      ]);

      // Ambil email dari user terkait berdasarkan user_id
      $user = User::findOrFail($validatedData['user_id ']);
      $validatedData['email'] = $user->email; // Gunakan email dari tabel users

      // Buat data karyawan baru
      $karyawan = Karyawan::create($validatedData);

      // Kembalikan response sukses
      return response()->json([
          'message' => 'Karyawan berhasil disimpan.',
          'data' => $karyawan,
      ], 201);
    }

    private function storeRiwayatPendidikan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id', // Pastikan id_karyawan sesuai dengan tabel karyawans
            'jenjang' => 'required|in:sd,smp,sma/smk,d3,s1,s2', // Validasi nilai ENUM
            'nama_sekolah' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|integer|digits:4', // Pastikan tahun berupa angka 4 digit
        ]);

        try {
            // Simpan data Riwayat Pendidikan
            $riwayatPendidikan = new RiwayatPendidikan();
            $riwayatPendidikan->fill($validatedData); // Menggunakan $fillable
            $riwayatPendidikan->save();

            return response()->json([
                'message' => 'Riwayat pendidikan berhasil disimpan.',
                'data' => $riwayatPendidikan
            ], 201);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data riwayat pendidikan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function storeKeluarga(Request $request)
    {
        // Logic untuk menyimpan data Pengalaman Kerja
    }

    private function storeKepegawaian(Request $request)
    {
        // Logic untuk menyimpan data Keluarga
    }
}
