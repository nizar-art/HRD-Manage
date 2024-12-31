<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regencies extends Model
{
  use HasFactory;

  public function provinces(){
    return $this->belongsTo(Provinces::class);
  }

  public function distracts(){
    return $this->hasMany(Distracts::class);
  }

}
