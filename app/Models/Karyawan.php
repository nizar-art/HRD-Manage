<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'karyawan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        'alamat_domisili',
        'email',
        'agama',
        'nomor_nik_ktp',
        'nomor_npwp',
        'nomor_rekening',
        'nomor_hp',
        'golongan_darah',
        'ibu_kandung',
        'status_pernikahan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the user that owns the karyawan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
