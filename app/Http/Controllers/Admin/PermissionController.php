<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.permission' , compact('permissions'));
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
        $validate = Validator::make($request->all() ,
        [
            'name' => 'required|unique:permissions',
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_add_permission', 'User wrong');  
            toast(__('Invalid request') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        Permission::create(['name' => $request->name]);
        toast(__('Permission created') , 'success');
        return back()->withSuccess(__('Permission created'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        if(is_null($permission)){
            toast(__('Not found role') , 'error');
            return back();
        }
        $roles = $permission->roles;
        foreach($roles as $role ){
            $role->revokePermissionTo($permission->name);
        }
        $permission->delete();
        toast(__('Permission removed') , 'success');
        return back()->withSuccess(__('Permission removed'));
        
    }
}
