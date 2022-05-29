<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // All registries for Admin
    public function registries(){
        $registries = Registry::all();
        $overview_reg = [];

        foreach($registries as $registry){

            $registry_articles = $registry->articles;
            $total = 0;
            foreach($registry_articles as $article){
                $art = Article::find($article['id']);

                if($article['status'] === 1 ){
                    $total += $art->price;
                }
            }
            $overview_reg[] = [$registry, 'total' => $total];
        }


        return view('admin.registries')->with(compact('overview_reg'));
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
