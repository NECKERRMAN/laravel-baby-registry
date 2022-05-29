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
        // Loop over every registry
        foreach($registries as $registry){
            // Get each registry's articles
            $registry_articles = $registry->articles;
            // set total price to 0
            $total = 0;
            // Loop over every article
            foreach($registry_articles as $article){
                // Get the correct article
                $art = Article::find($article['id']);
                // If bought add price to total
                if($article['status'] === 1 ){
                    $total += $art->price;
                }
            }
            // Create array with registry details and total for everey registry
            $overview_reg[] = [$registry, 'total' => $total];
        }


        return view('admin.registries')->with(compact('overview_reg'));
    }

    // All users for admin
    public function users(){
        $users = User::all();
        return view('admin.users')->with(compact('users'));
    }

    // All categories
    public function categories(){
        $categories = Category::all();
        return view('admin.categories')->with(compact('categories'));
    }

    // All articles
    public function articles(Request $req){
        $category_id = $req->category;

        // Get all articles in ascending price order
        $articles = Article::orderBy('price', 'asc')->paginate(20);
        // Filter on category
        if($category_id == 0){
            $articles = Article::orderBy('price', 'asc')->paginate(20);
        } else {
            $articles = Article::where('category_id', '=', $category_id)->paginate(20);
        }

        return view('admin.articles', [
            'articles' => $articles,
            'categories' => Category::all(),
        ]);
    }
}
