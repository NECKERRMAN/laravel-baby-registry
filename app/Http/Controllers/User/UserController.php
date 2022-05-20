<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function all(){
        $users = User::all();
        dd($users);
    }

    public function showUserDetails(){
        $user = Auth::user();
        dd($user);
    }
}
