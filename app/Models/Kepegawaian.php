<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kepegawaian extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kepegawaians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_karyawan',
        'nomer_kerja',
        'tanggal_masuk',
        'id_department',
        'id_jabatan',
        'lokasi_kerja',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    /**
     * Get the karyawan that owns the kepegawaian record.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    /**
     * Get the department associated with the kepegawaian record.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
    }

    /**
     * Get the job (jabatan) associated with the kepegawaian record.
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
