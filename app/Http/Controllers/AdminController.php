<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class AdminController extends Controller
{
    //
    public function list_users()
    {
        $users = User::paginate(5);
        return view('admin.users.list_users',['users' => $users]);
    }

    public function promotion(Request $request)
    {
        $user= User::find($request->user_id);
        $user->is_admin = !$user->is_admin;
        if($user->save()){
            if($user->is_admin){
                return response()->json(['success'=>'Promoted!']);
            }
            return response()->json(['success'=>'Demoted!']);
        }
        return response()->json(['failed'=>'Process failed successfully :) !']);
    }

    public function activation(Request $request)
    {
        $user= User::find($request->user_id);
        $user->is_active = !$user->is_active;
        if($user->save()){
            if($user->is_active){
                return response()->json(['success'=>'Activated!']);
            }
            return response()->json(['success'=>'Deactivated!']);
        }
    }
}
