<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{   
    // Get home page
    public function index(){
        return view('home');
    }  

    // Return the correct dashboard
    public function dashboard(){
        // Get data for Admin dashboard
        $articles = count(Article::all());
        $users = count(User::all());
        $registries = count(Registry::all());
        // hasRole gives error 'not defined' but works...
        // If user is user return dashboard
        if(Auth::user()->hasRole('user')){
            return view('dashboard');
        } elseif(Auth::user()->hasRole('admin')){
            return view('adminDashboard', [
                'n_art' => $articles,
                'n_users' => $users,
                'n_reg' => $registries
            ]);
        } else {
            return abort(404);
        }
        
    } 
}
