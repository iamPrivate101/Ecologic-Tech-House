<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories() {
        Session::put('page','categories'); 
        $categories = Category::with('parentcategory')->get();
        return view('admin.categories.categories')->with(compact('categories'));
    }
}
