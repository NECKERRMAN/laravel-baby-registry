<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(){
        return view('home');
    }

    public function dashboard(){
        $articles = count(Article::all());
        $users = count(User::all());
        $registries = count(Registry::all());
        // hasRole is not defined but works
        if(Auth::user()->hasRole('user')){
            return view('dashboard');
        } elseif(Auth::user()->hasRole('admin')){
            return view('adminDashboard', [
                'n_art' => $articles,
                'n_users' => $users,
                'n_reg' => $registries
            ]);
        } else {

        }
        
    }

    public function test(){
        return 'Admin- test';
    }
}
