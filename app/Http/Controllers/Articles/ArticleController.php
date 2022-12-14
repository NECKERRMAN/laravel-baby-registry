<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
use App\Models\Store;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Get all articles
    public function articles(){
        return view('articles.articles', [
            'articles' => Article::all(),
            'categories' => Category::all(),
        ]);
    }

    // Get specific article by ID
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

    // Add article to cart for visitor
    public function add(Request $req){
        $article = Article::findOrFail($req->article_id);

        Cart::session(1)->add(array(
            'id' => $article->id,
            'name' => $article->title,
            'price' => $article->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $article
        ));

        return redirect()->back();
    }

    // Clear the cart
    public function clear(Request $req){
        Cart::session(1)->clear();
        return redirect()->back();

    }

    // Delete article from DB
    public function delete(Request $req){
        $article_id = $req->article_id;
        $delete_article = Article::find($article_id)->delete();
        return redirect()->back();
    }
}
