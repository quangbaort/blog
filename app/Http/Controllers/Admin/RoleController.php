<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Validator;
use App\User;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.role' , compact('roles'  , 'permissions'));
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
            'name' => 'required|unique:roles',
        ]);
        if($validate->fails()){
            $validate->getMessageBag()->add('error_add_role', 'User wrong');  
            toast(__('Invalid request') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        Role::create(['name' => $request->name]);
        toast(__('Role created') , 'success');
        return back()->withSuccess(__('Role created'));
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
        $role = Role::find($id);
        if(is_null($role)){
            toast(__('Not found role') , 'error');
            return back();
        }
        foreach($role->permissions as $permission){
            $role->revokePermissionTo($permission);
        }
        $role->givePermissionTo($request->permissions);
        toast(__('Update role successfully') , 'success');
        return back()->withSuccess(__('Role successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if(is_null($role)){
            toast(__('Not found role') , 'error');
            return back();
        }
        $users = User::role($role->name)->count();
        if($users > 0) {
            toast(__('Role have user') , 'error');
            return back();
        }
        $role->delete();
        toast(__('Role successfully removed') , 'success');
        return back()->withSuccess(__('Role successfully removed'));
    }
}
