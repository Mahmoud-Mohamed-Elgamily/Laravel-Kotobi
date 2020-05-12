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
}
