<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class EcommerceProductCategory extends Controller
{
  public function index()
  {
    return view('content.apps.app-ecommerce-category-list');
  }
  public function show($slug)
  {
    $category = Category::where('slug', $slug)->firstOrFail();
    return view('categories.show', compact('category'));
  }
}
