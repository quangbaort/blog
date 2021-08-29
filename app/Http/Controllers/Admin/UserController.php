<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $users = $user::where('id' , '>=' , 1)->orderBy('created_at' , 'desc')->get();
        $roles = Role::all();
        return view('admin.users' , compact('users' , 'roles'));
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
    public function store(Request $request , User $user)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|min:6|max:20|string|without_spaces|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:users',
        'name' => 'required|min:2|max:50',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            'role' => 'required'
        ]);

        if($validate->fails()) {
            $validate->getMessageBag()->add('error_user', 'User wrong');  
            return back()->withErrors($validate->errors())->withInput();
        }
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        for($i = 0; $i < count($request->role); $i++){
            $user->assignRole($request->role[$i]);
        }
        $user->save();
        toast(__('Your account has been created') , 'success');
        return back()->withSuccess(__('Your account has been created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|min:6|max:20|string|without_spaces|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:users,username,'.$id .'id',
        'name' => 'required|min:2|max:50',
            'role' => 'required'
        ]);

        if($validate->fails()) {
            $validate->getMessageBag()->add('error_user', $id);  
            return back()->withErrors($validate->errors());
        }
        $user = User::find($id);
        if(is_null($user)){
            toast(__('Not found role') , 'error');
            return back();
        }
        foreach($user->roles as $role) {
            $user->removeRole($role->name);
        }
        $user->username = $request->username;
        $user->name = $request->name;
        for($i = 0; $i < count($request->role); $i++){
            $user->assignRole($request->role[$i]);
        }
        $user->save();
        toast(__('Update user successfuly') , 'success');
        return back()->withSuccess(__('Update user successfuly'));
    }

    public function changePasswordUser(Request $request , $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
        ]);
        if($validate->fails()) {
            $validate->getMessageBag()->add('error_password', $id);  
            return back()->withErrors($validate->errors())->withInput();

        }
        $user = User::find($id);
        if(is_null($user)){
            toast(__('Not found role') , 'error');
            return back();
        }
        $user->password = Hash::make($request->password);
        $user->save();
        toast(__('Update user successfuly') , 'success');
        return back()->withSuccess(__('Update user successfuly'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            toast(__('Not fount user') , 'error');
            return back();
        }
        foreach($user->roles as $role) {
            $user->removeRole($role->name);
        }
        $user->delete();
        toast(__('Delete user successfuly') , 'success');
        return back()->withSuccess(__('Delete user successfuly'));
    }
}
