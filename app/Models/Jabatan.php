<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'Jabatan';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name_jabatan',
    'id_department',
  ];
  /**
   * Get the department associated with the jabatan.
   */
  public function department()
  {
    return $this->belongsTo(Department::class, 'id_department');
  }

  /**
   * Get the kepegawaian records associated with the jabatan.
   */
  public function kepegawaian()
  {
    return $this->hasMany(Kepegawaian::class, 'id_jabatan');
  }
}
