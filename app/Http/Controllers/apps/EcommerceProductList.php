<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcommerceProductList extends Controller
{
  public function index()
  {
    return view('content.hrd.profile-karyawan-list');
  }
}