<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class CategoryJabatan extends Controller
{
  public function index()
  {
    // Mengambil semua data departemen
    $departments = Department::all(); // Anda bisa menambahkan where() atau orderBy() jika diperlukan
    return view('content.category.category-jabatan', compact('departments'));
  }
  public function getJabatan(Request $request)
  {
      // Ambil data jabatan beserta name_department melalui relasi
      $jabatans = Jabatan::with('department:id,name_department')->get();

      // Format data sesuai kebutuhan DataTable
      $formattedData = $jabatans->map(function ($jabatan) {
          return [
              'id' => $jabatan->id, // ID asli
              'name_jabatan' => $jabatan->name_jabatan,
              'name_department' => $jabatan->department->name_department ?? '-' // Ambil nama department dari relasi
          ];
      });

      // Return response JSON
      return response()->json([
          'data' => $formattedData
      ]);
  }

  public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_jabatan' => 'required|string|max:100|unique:Jabatan,name_jabatan', // Sesuaikan nama tabel
            'id_department' => 'required|exists:Department,id', // Validasi foreign key
        ]);

        // Simpan data ke dalam database menggunakan mass assignment
        $jabatan = Jabatan::create([
            'name_jabatan' => $request->input('name_jabatan'),
            'id_department' => $request->input('id_department'),
        ]);

        // Kembalikan respon JSON
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $jabatan,
        ], 201);
    }

    public function edit($id)
    {
        // Cari data Jabatan berdasarkan ID
        $jabatan = Jabatan::with('department:id,name_department')->findOrFail($id);

        // Return response JSON untuk kebutuhan edit
        return response()->json([
            'data' => $jabatan
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name_jabatan' => 'required|string|max:100|unique:Jabatan,name_jabatan,' . $id, // Ignore current record
            'id_department' => 'required|exists:Department,id', // Validasi foreign key
        ]);

        // Cari data Jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);

        // Update data Jabatan
        $jabatan->update([
            'name_jabatan' => $request->input('name_jabatan'),
            'id_department' => $request->input('id_department'),
        ]);

        // Kembalikan respon JSON
        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $jabatan,
        ]);
    }

    public function destroy($id)
    {
        // Cari data Jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);

        // Hapus data Jabatan
        $jabatan->delete();

        // Kembalikan respon JSON
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }


}
