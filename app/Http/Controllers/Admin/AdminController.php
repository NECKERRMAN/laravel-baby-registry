<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // All registries for Admin
    public function registries(){
        $registries = Registry::all();
        return view('admin.registries')->with(compact('registries'));
    }

    public function users(){
        $users = User::all();
        return view('admin.users')->with(compact('users'));
    }

    public function categories(){
        $categories = Category::all();
        return view('admin.categories')->with(compact('categories'));
    }
}
