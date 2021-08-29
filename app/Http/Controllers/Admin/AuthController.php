<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }
    public function postLogin(Request $request)
    {
        $validate = Validator::make($request->all() , [
            'username' => 'required|min:6|max:20|string|without_spaces|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'password' => 'required|min:6'
        ]);     

        if($validate->fails()){
            toast(__('Invalid username or password') , 'error');
            return back()->withInput()->withErrors($validate->errors());
        }
        if(Auth::attempt($request->only(['username' , 'password']))){
            toast(__('Login successful') , 'success');
            return redirect(route('admin.dashboard'));
        }
        toast(__('Login failed') , 'error');
        return back();
            
   
    }
    public function profile(User $user)
    {
        $profile = $user::find(Auth::user()->id);
        return view('admin.profile' , compact('profile'));
    }
    public function updateAvatar(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validate->fails()){
            toast(__('Update unsuccessfuly') , 'error');
            return back()->withErrors($validate->errors());
        }
        $image = $request->file('avatar');
        $path = $image->store('public/avatar');
        $avatar = Storage::url($path);
        $user = User::find(Auth::user()->id);
        $user->avatar = $avatar;  
        $user->save();
        toast(__('Update successfuly') , 'success');
        return back()->withSuccess(__('Avatar updated successfully'));

    }
    public function updateInfo(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'username' => 'required|min:6|max:20|string|without_spaces|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:users,username,'.Auth::user()->id,
            'name' => 'required|max:50|min:2|string'
        ], [
            "username.without_spaces" => "The username format is invalid."
        ]);
        if($validate->fails()){
            toast(__('Update unsuccessfuly') , 'error');
            return back()->withErrors($validate->errors())->withInput();
        }
        $user = Auth::user();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->save();
        toast(__('Update successfuly') , 'success');
        return back();
    }
    public function updatePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password_old' => 'required|min:6',
            'password_new' => 'required|min:6',
            'password_comfirm' => 'required|min:6|same:password_new'
        ]);
        
        if($validate->fails()){
            $validate->getMessageBag()->add('error_password_reset', 'Password wrong');  
            toast(__('Update unsuccessfuly') , 'error');
            return back()->withErrors($validate->errors());
        }
        if(Hash::check($request->password_old , Auth::user()->password )){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password_new);
            $user->save();
            toast(__('Update successfuly') , 'success');
            return back()->withSuccess(__('Password changed successfully'));
        }
        $validate->getMessageBag()->add('error_password', 'Password wrong'); 
        // $validate->getMessageBag()->add('password_old', 'Password wrong'); 

        toast(__('Update failed') , 'error');
        return back()->withErrors($validate->errors());

    }
}
