<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['category' , 'tag'])->get();
        // dd($articles);
        return view('admin.article.article' , compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.article.create' , compact('categories' , 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all() , [
            'title' => 'required|min:6|unique:articles,title',
            'avatar' => 'required',
            'article_text' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tag_id.*' => 'required|exists:tags,id'
        ]);
        if($validate->fails()){
            toast(__('Create post fail') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'avatar' => $request->avatar,
            'article_text' => $request->article_text,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id
        ]);
        
        $article->tag()->sync((array)$request->tag_id);
        toast(__('Create post success') , 'success');
        return redirect(route('admin.article'))->withSuccess('Create post success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articel  $articel
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Articel  $articel
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article , $id)
    {
        $article = $article->find($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.article.edit' , compact('categories' , 'tags' , 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articel  $articel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $validate = Validator::make($request->all() , [
            'title' => 'required|min:6|unique:articles,title,'.$id,
            'avatar' => 'required',
            'article_text' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tag_id.*' => 'required|exists:tags,id'
        ]);
        if($validate->fails()){
            toast(__('Create post fail') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $article = Article::find($id);
        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'avatar' => $request->avatar,
            'article_text' => $request->article_text,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
        ]);
        
        $article->tag()->sync((array)$request->tag_id);
        toast(__('Create post success') , 'success');
        return redirect(route('admin.article'))->withSuccess('Updated post success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articel  $articel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if(is_null($article)){
            toast(__('Not found post') , 'error');
            return back();
        }
        $article->delete();
        toast(__('Deleted post') , 'success');
        return back()->withSuccess('Deleted post');
    }
}
