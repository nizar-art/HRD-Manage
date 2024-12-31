<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('kontrak_kerja', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade')->onUpdate('cascade');
        $table->date('start_date'); // Kolom untuk tanggal mulai
        $table->date('end_date');   // Kolom untuk tanggal akhir
        $table->enum('status',['Baru','Lanjut']);
        $table->timestamps();       // Kolom created_at dan updated_at
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_kerja');
    }
};
