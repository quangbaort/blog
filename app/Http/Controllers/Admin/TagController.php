<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;
use Illuminate\Support\Str;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('created_at', 'desc')->get();
        return view('admin.tag' , compact('tags'));
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
    public function store(Request $request , Tag $tag)
    {
        $validate = Validator::make($request->all() ,
        [
            'name' => 'required|unique:tags,name',
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_add_tag', 'User wrong');  
            toast(__('Invalid request') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        toast(__('Successfully created') , 'success');
        return back()->withSuccess('Successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $validate = Validator::make($request->all() ,
        [
            'name' => 'required|unique:tags,name,'.$id,
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_add_tag', 'User wrong');  
            toast(__('Invalid request') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        toast(__('Updated successfully') , 'success');
        return back()->withSuccess('Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if(is_null($tag)){
            toast(__('Not fount tag') , 'error');
            return back();
        }
        $tag->delete();
        toast(__('Delete tag successfuly') , 'success');
        return back()->withSuccess(__('Delete tag successfuly'));

    }
}
