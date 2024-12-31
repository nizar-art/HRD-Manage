<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
  use HasFactory;

  public function regencies(){
    return $this->hasMany(Regencies::class);
  }
}
