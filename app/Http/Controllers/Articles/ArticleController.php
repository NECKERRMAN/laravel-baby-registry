<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function articles(){
        return view('articles.articles', [
            'articles' => Article::all(),
            'categories' => Category::all(),
        ]);
    }

    public function getArticle(Request $req){
        $article_id = $req->id;
        $article = Article::find($article_id);
        $store = Store::find($article->store_id);
        $category = Category::find($article->category_id);

        return view('articles.article', [
            'article' => $article,
            'store' => $store,
            'category' => $category,
        ]);
    }
}
