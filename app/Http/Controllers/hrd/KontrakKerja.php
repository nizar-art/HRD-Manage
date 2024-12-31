<?php

namespace App\Http\Controllers\hrd;

use App\Http\Controllers\Controller;
use App\Models\KontrakKerja as ModelsKontrakKerja;
use App\Models\Karyawan;
use App\Models\HistoryKontrak;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KontrakKerja extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('content.hrd.kontrak-kerja', compact('karyawan'));
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id', // pastikan id_karyawan ada dalam tabel karyawan
            'start_date' => 'required|date', // validasi tanggal mulai
            'end_date' => 'required|date|after:start_date', // validasi tanggal akhir setelah start_date
            'status' => 'required|in:Baru,Lanjut', // validasi status
        ]);

        // Membuat entri baru di tabel kontrak_kerja
        $kontrakKerja = ModelsKontrakKerja::create([
            'id_karyawan' => $request->id_karyawan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // buat history kontrak
        HistoryKontrak::create([
            'id_kontrak_kerja' => $kontrakKerja->id,
            'id_karyawan' => $request->id_karyawan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Mengembalikan response sukses
        return response()->json(['message' => 'Kontrak Kerja created successfully', 'data' => $kontrakKerja], 201);
    }

    public function getAll()
    {
        // Ambil semua data kontrak kerja dengan relasi ke tabel karyawan
        $kontrakKerjas = ModelsKontrakKerja::with([
            'karyawan:id,nama_lengkap' // Relasi dengan karyawan untuk mengambil nama lengkap
        ])->get();

        // Format data yang diambil
        $formattedData = $kontrakKerjas->map(function ($kontrakKerja) {
            // Hitung durasi kontrak
            $start_date = Carbon::parse($kontrakKerja->start_date);
            $end_date = Carbon::parse($kontrakKerja->end_date);
            $today = Carbon::now();

            // Pastikan end_date tidak lebih kecil dari start_date
            if ($end_date->lt($start_date)) {
                $end_date = $start_date->copy();
            }

            // Hitung selisih waktu (Sisa kontrak dari hari ini ke end_date)
            $remainingDays = $today->diffInDays($end_date, false); // False untuk memperhitungkan negatif jika sudah lewat
            $remainingDuration = $today->diff($end_date);

            // Format durasi sisa kontrak
            $remainingText = $remainingDays >= 0
                ? "{$remainingDuration->m} bulan {$remainingDuration->d} hari"
                : 'Kontrak berakhir';

            // Hitung total jumlah kontrak dalam hari (dari start ke end)
            $totalDays = $start_date->diffInDays($end_date);

            return [
                'id' => $kontrakKerja->id,
                'nama_lengkap' => $kontrakKerja->karyawan ? ucfirst($kontrakKerja->karyawan->nama_lengkap) : '-',
                'start_date' => $start_date->format('Y-m-d'),
                'end_date' => $end_date->format('Y-m-d'),
                'status' => $kontrakKerja->status,
                'duration' => "{$totalDays} hari",  // Total durasi kontrak
                'remaining_duration' => $remainingText,  // Sisa kontrak
                'remaining_days' => $remainingDays >= 0 ? "{$remainingDays} hari" : 'Berakhir'
            ];
        });

        return response()->json(['data' => $formattedData]);
    }

    public function edit($id)
    {
        // Ambil data kontrak kerja berdasarkan ID
        $kontrakKerja = ModelsKontrakKerja::find($id);

        // Pastikan data ada
        if (!$kontrakKerja) {
            return response()->json(['message' => 'Kontrak Kerja not found'], 404);
        }

        // Kembalikan data kontrak untuk diedit
        return response()->json(['data' => $kontrakKerja]);
    }

    public function update(Request $request, $id)
    {
        // Validasi inputan
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:Baru,Lanjut',
        ]);

        // Cari kontrak kerja berdasarkan ID
        $kontrakKerja = ModelsKontrakKerja::find($id);

        if (!$kontrakKerja) {
            return response()->json(['message' => 'Kontrak Kerja not found'], 404);
        }

        // Perbarui kontrak kerja
        $kontrakKerja->update([
            'id_karyawan' => $request->id_karyawan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // history kontrak edit
        HistoryKontrak::create([
            'id_kontrak_kerja' => $kontrakKerja->id,
            'id_karyawan' => $kontrakKerja->id_karyawan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Mengembalikan response sukses
        return response()->json(['message' => 'Kontrak Kerja updated successfully', 'data' => $kontrakKerja]);
    }
    // buat delete
    public function delete($id)
    {
        // Cari kontrak kerja berdasarkan ID
        $kontrakKerja = ModelsKontrakKerja::find($id);

        if (!$kontrakKerja) {
            return response()->json(['message' => 'Kontrak Kerja not found'], 404);
        }

        // Hapus kontrak kerja
        $kontrakKerja->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Kontrak Kerja deleted successfully']);
    }

    public function lanjut(Request $request, $id)
    {
        // Validasi inputan
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:Lanjut',
        ]);

        // Cari kontrak kerja berdasarkan ID
        $kontrakKerja = ModelsKontrakKerja::find($id);

        if (!$kontrakKerja) {
            return response()->json(['message' => 'Kontrak Kerja not found'], 404);
        }


        // Perbarui data kontrak kerja dengan data baru
        $kontrakKerja->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Pindahkan data sebelumnya ke history_contract
        HistoryKontrak::create([
            'id_kontrak_kerja' => $kontrakKerja->id,
            'id_karyawan' => $kontrakKerja->id_karyawan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);
        // Mengembalikan response sukses
        return response()->json(['message' => 'Kontrak Kerja extended successfully', 'data' => $kontrakKerja]);
    }
}
