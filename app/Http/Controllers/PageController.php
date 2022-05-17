<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(){
        return view('home');
    }

    public function dashboard(){

        if(Auth::user()->hasRole('user')){
            return view('dashboard');
        } elseif(Auth::user()->hasRole('admin')){
            return view('adminDashboard');
        } else {
            
        }
        
    }

    public function test(){
        return 'Admin- test';
    }
}
