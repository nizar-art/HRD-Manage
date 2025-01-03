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
    Schema::create('karyawan', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->string('nama_lengkap', 255);
      $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
      $table->string('tempat_lahir');
      $table->date('tanggal_lahir');
      $table->text('alamat_ktp');
      $table->text('alamat_domisili');
      $table->string('email')->unique();
      $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Konghucu', 'Budha', 'Hindu']);
      $table->string('nomor_nik_ktp', 16);
      $table->string('nomor_npwp', 20)->nullable();
      $table->string('nomor_rekening', 20)->nullable();
      $table->string('nomor_hp', 15);
      $table->enum('golongan_darah', ['A', 'B', 'O', 'AB', 'A-', 'B-', 'O-', 'AB-']);
      $table->string('ibu_kandung');
      $table->enum('status_pernikahan', ['menikah', 'belum menikah', 'janda/duda']);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('karyawan_table');
  }
};