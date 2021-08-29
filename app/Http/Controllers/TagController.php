<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
class TagController extends Controller
{
    public function index(Request $request , $slug = null)
    {
        if(is_null($slug) || $slug == ""){
            abort(404);
        }
        $tag = Tag::where('slug', $slug)->first();
        if(is_null($tag)){
            abort(404);
        }
        // dd($tag->article);
        return view('users.tag' , compact('tag'));

    }
}
