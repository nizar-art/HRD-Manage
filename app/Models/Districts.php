<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
  use HasFactory;

  public function regencies(){
    return $this->belongsTo(Regencies::class);
  }

  public function villages(){
    return $this->hasMany(Villages::class);
  }
}
