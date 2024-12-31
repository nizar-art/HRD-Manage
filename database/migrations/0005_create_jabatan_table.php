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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('name_jabatan', 100)->unique();
            $table->unsignedBigInteger('id_department');
            $table->timestamps();
            $table->softDeletes();

            //FK
            $table->foreign('id_department')
                ->references('id')
                ->on('department')
                ->onDelete('no action')
                ->onUpdate('no action');
                ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
