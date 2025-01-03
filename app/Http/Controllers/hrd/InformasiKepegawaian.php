<?php

namespace App\Http\Controllers\hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kepegawaian;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class InformasiKepegawaian extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        $departments = Department::all();
        $jabatan = Jabatan::all();
        return view('content.hrd.informasi-kepegawaian', compact('karyawan', 'departments', 'jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'perusahaan' => 'required|string|in:LKI,Green Cold',
            'nomer_kerja' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'id_department' => 'required|exists:department,id',
            'id_jabatan' => 'required|exists:jabatan,id',
            'lokasi_kerja' => 'required|string|max:255',
        ]);

        $kepegawaian = Kepegawaian::create([
            'id_karyawan' => $request->id_karyawan,
            'perusahaan' => $request->perusahaan,
            'nomer_kerja' => $request->nomer_kerja,
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_department' => $request->id_department,
            'id_jabatan' => $request->id_jabatan,
            'lokasi_kerja' => $request->lokasi_kerja,
        ]);

        return response()->json(['message' => 'Kepegawaian created successfully', 'user' => $kepegawaian], 201);
    }

    public function getAll()
    {
        $kepegawaians = Kepegawaian::with([
            'karyawan:id,nama_lengkap',
            'jabatan:id,name_jabatan',
            'department:id,name_department'
        ])->get();

        $formattedData = $kepegawaians->map(function ($kepegawaian) {
            return [
                'id' => $kepegawaian->id,
                'nama_lengkap' => $kepegawaian->karyawan ? ucfirst($kepegawaian->karyawan->nama_lengkap) : null,
                'perusahaan' => $kepegawaian->perusahaan,
                'nomer_kerja' => $kepegawaian->nomer_kerja,
                'tanggal_masuk' => $kepegawaian->tanggal_masuk ? $kepegawaian->tanggal_masuk->format('Y-m-d') : null,
                'name_jabatan' => $kepegawaian->jabatan->name_jabatan ??'-',
                'name_department' => $kepegawaian->department->name_department ??'-',
                'lokasi_kerja' => $kepegawaian->lokasi_kerja,
            ];
        });

        return response()->json([
            'data' => $formattedData
        ]);
    }

    public function edit($id)
    {
        $kepegawaian = Kepegawaian::with(['karyawan', 'department', 'jabatan'])->findOrFail($id);

        return response()->json([
            'message' => 'Data fetched successfully',
            'data' => $kepegawaian
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'perusahaan' => 'required|string|in:LKI,Green Cold',
            'nomer_kerja' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'id_department' => 'required|exists:department,id',
            'id_jabatan' => 'required|exists:jabatan,id',
            'lokasi_kerja' => 'required|string|max:255',
        ]);

        $kepegawaian = Kepegawaian::findOrFail($id);
        $kepegawaian->update([
            'id_karyawan' => $request->id_karyawan,
            'perusahaan' => $request->perusahaan,
            'nomer_kerja' => $request->nomer_kerja,
            'tanggal_masuk' => $request->tanggal_masuk,
            'id_department' => $request->id_department,
            'id_jabatan' => $request->id_jabatan,
            'lokasi_kerja' => $request->lokasi_kerja,
        ]);

        return response()->json(['message' => 'Kepegawaian updated successfully', 'user' => $kepegawaian], 200);
    }

    public function delete($id)
    {
        $kepegawaian = Kepegawaian::findOrFail($id);
        $kepegawaian->delete();

        return response()->json(['message' => 'Kepegawaian deleted successfully'], 200);
    }
}
