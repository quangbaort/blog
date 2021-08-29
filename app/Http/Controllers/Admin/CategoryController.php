<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at' , 'desc')->get();
        return view('admin.category' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|unique:categories,name',
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_add_category', 'Category wrong');  
            toast(__('Fail') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        toast(__('Category created') , 'success');
        return back()->withSuccess(__('Category created')); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|unique:categories,name,'.$id,
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_update_category', $id);  
            toast(__('Name is required') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $category = Category::find($id);
        if(is_null($category)){
            toast(__('Not found role') , 'error');
            return back();
        }
        $category->update(['name' => $request->name]);
        toast(__('Updated category') , 'success');
        return back()->withSuccess(__('Updated category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(is_null($category)){
            toast(__('Not found role') , 'error');
            return back();
        }
        $category->delete();
        toast(__('Category removed') , 'success');
        return back()->withSuccess(__('Category removed'));
    }
}
