<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
class ArticleController extends Controller
{
    public function index($slug)
    {
        if(is_null($slug) || $slug == ""){
            abort(404);
        }
        $article = Article::where('slug', $slug)->first();
        if(is_null($article)){
            abort(404);
        }
        return view('users.article-detail' , compact('article'));
    }
}
