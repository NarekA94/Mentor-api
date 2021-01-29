<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(){
        return response(['data' => Auth::user()], 200);
    }

    public function getUsers(){
        $users = User::all();
        return response([$users], 200); ;
    }
}
