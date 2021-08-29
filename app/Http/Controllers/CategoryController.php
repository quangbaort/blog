<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index($slug = null)
    {
        if(is_null($slug) || $slug == ""){
            abort(404);
        }
        $category = Category::where('slug' , $slug)->first();
        if(is_null($category)){
            abort(404);
        }
        // dd($category->article);
        return view('users.category' , compact('category'));
    }
}
