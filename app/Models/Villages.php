<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
  use HasFactory;

  public function districs(){
    return $this->belongsTo(Districs::class);
  }
}
