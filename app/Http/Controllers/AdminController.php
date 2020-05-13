<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Auth;
class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('is.admin');
    }

    //list all users
    //GET /admin/users
    public function list_users()
    {
        $users = User::paginate(5);
        return view('admin.users.list_users',['users' => $users]);
    }

    //promoting to admin
    //POST /admin/user/promotion
    public function promotion(Request $request)
    {
        if(@auth::user()->is_admin){
            $user= User::find($request->user_id);
            $user->is_admin = !$user->is_admin;
            if($user->save()){
                if($user->is_admin){
                    return response()->json(['success'=>'Promoted!']);
                }
                return response()->json(['success'=>'Demoted!']);
            }
        }
        return response()->json(null,500);
    }

    //activate user
    //POST /admin/user/activation
    public function activation(Request $request)
    {
        if(@auth::user()->is_admin){
            $user= User::find($request->user_id);
            $user->is_active = !$user->is_active;
            if($user->save()){
                if($user->is_active){
                    return response()->json(['success'=>'Activated!']);
                }
                return response()->json(['success'=>'Deactivated!']);
            }
        }
        return response()->json(null,500);
    }

    //open edit user form
    //GET /admin/user/{user}/edit
    public function edit_user(Request $request, User $user)
    {
        return view('admin.users.edit',['user' => $user]);
    }


    //send edit user form
    //POST /admin/user/{user}/edit
    public function update_user(UserRequest $request, User $user)
    {
        if(@auth::user()->is_admin){
            if($request->has('avatar')){
                $avatar = $request->avatar->store('uploads', 'public');
                $user->avatar = $avatar;
            }
            $user->name=$request->name;
            $user->username=$request->username;
            $user->email=$request->email;
            if($user->save()){
                return redirect()->route('list_users')->with(['status'=> 'User Updated Successfully!','class'=>'success']);
            }
        }
        return redirect()->route('list_users')->with(['status'=> 'Operation Failed :) !','class'=>'danger']);
    }
}
