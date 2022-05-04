<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return view('home');
    }

    public function articles(){

        return view('articles.articles', [
            'articles' => Article::all(),
            'categories' => Category::all(),
        ]);
    }
}
