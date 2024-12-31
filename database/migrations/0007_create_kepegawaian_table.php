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
        Schema::create('kepegawaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_department')->constrained('department')->onDelete('no action')->onUpdate('cascade');
            $table->foreignId('id_jabatan')->constrained('jabatan')->onDelete('no action')->onUpdate('cascade');
            $table->string('nomer_kerja', 50);
            $table->date('tanggal_masuk');
            $table->string('lokasi_kerja', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepegawaian');
    }
};
