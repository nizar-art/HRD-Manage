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
    Schema::create('history_contract', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_kontrak_kerja')->constrained('kontrak_kerja')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade')->onUpdate('cascade');
      $table->date('start_date'); // Kolom untuk tanggal mulai
      $table->date('end_date');   // Kolom untuk tanggal akhir
      $table->enum('status', ['Baru', 'Lanjut']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('history_contract');
  }
};
