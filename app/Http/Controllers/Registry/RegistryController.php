<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class RegistryController extends Controller
{


    public function index(){
        $user_id = auth()->user()->id;
        $user_registries = Registry::where('user_id', '=', $user_id)->get();
        return view('registry.registries', [
            'registries' => $user_registries,
        ]);

    }

    public function new(){
        return view('registry.create');
    }

    // Save registry
    public function createRegistry(Request $req){
        $user_id = $req->user_id;
        // Unique slug for the list babyname + userID + birthdate
        $slug = strtolower($req->babyName) . '-' . $user_id . '-' . $req->birthdate;
        $registry = new Registry();
        $registry->user_id = $user_id;
        $registry->name = $req->registryName;
        $registry->baby_name = $req->babyName;
        $registry->birthdate = $req->birthdate;
        $registry->slug = $slug;
        $registry->password = $req->password_registry;
        $registry->articles = serialize([]);
        $registry->save();

        return redirect()->route('registry.all');
        
    }

    // edit registry
    public function editRegistry(Registry $registry){
        dd('edit');
    }

    // Function to get all current registry articles
    public function getCurrentArticles($id){
        $registry = Registry::find($id);
        $registry_articles = unserialize($registry->articles);

        $current_articles[] = '';

        foreach($registry_articles as $article){
            $art = Article::find($article);

            $current_articles[] = $art->title;
        }

        return $current_articles;
    }

    // Get all articles
    public function allArticles(Request $req){
        $registry = Registry::find($req->id);
        // Check if user has acces
        if(auth()->user()->id !== $registry->user_id){
            return redirect()->back();
        }
        
        $articles = Article::orderBy('price', 'asc')->get();
        $current_articles = $this->getCurrentArticles($req->id);

        return view('registry.items', [
            'registry' => $registry,
            'articles' => $articles,
            'current_articles' => $current_articles,
            'categories' => Category::all()
        ]);
    }
    
    // Add article to wishlist
    public function addArticle(Request $req){
        $current_registry = Registry::findOrFail($req->reg_id);
        $current_articles = unserialize($current_registry->articles);
        $new_article = Article::findOrFail($req->article_id);

        if(in_array($new_article, $current_articles)){
            return redirect()->route('registry.addArticles', ['id' => $current_registry->id])->withErrors(['msg' => 'Item is already added']);
        }

        $current_articles[] = $new_article->id;

        $current_registry->articles = serialize($current_articles);
        $current_registry->save();

        return redirect()->route('registry.addArticles', ['id' => $current_registry->id]);

    }

    public function filterArticles(Request $req){
        $category_id = '';
        $articles = '';
        $registry = Registry::find($req->id);
        $current_articles = $this->getCurrentArticles($req->id);

        // Filter on category
        if($req->filter_categories !== 'all'){
            $category_id = $req->filter_categories;
            // Filter on price
            if($req->priceRange === 'high-low'){
                $articles = Article::where('category_id', '=', $category_id)
                    ->orderBy('price', 'desc')
                    ->get();
            } else {
                $articles = Article::where('category_id', '=', $category_id)
                ->orderBy('price', 'asc')
                ->get();
            }
        } else {
            if($req->priceRange === 'high-low'){
                $articles = Article::orderBy('price', 'desc')->get();
            } else {
                $articles = Article::orderBy('price', 'asc')->get();
            }
        }
        

        return view('registry.items', [
            'registry' => $registry,
            'articles' => $articles,
            'current_articles' => $current_articles,
            'categories' => Category::all()
        ]);
    }

    public function showOverview(Request $req){
        $registry = Registry::find($req->id);
        $articles = $this->getRegistryArticles($registry);

        return view('registry.overview', [
                'registry' => $registry,
                'articles' => $articles
        ]);
    }

    public function locked(Request $req){
        $reg_slug = $req->slug;
        $registry = Registry::where('slug', '=', $reg_slug)->first();
        $articles = $this->getRegistryArticles($registry);

        $cart = Cart::session(1);

        return view('registry.visitor', [
                'registry' => $registry,
                'articles' => $articles,
                'cart' => $cart
        ]);
    }
    
    public function unlocked(Request $req){
        $correct_registry = Registry::find($req->reg_id);
        if($req->secret_password === $correct_registry->password){
            dd('correct');
            return view('registry.registry', [
                'registry' => $correct_registry
            ]);
        }
    }

    private function getRegistryArticles($registry){
        $reg_articles = $registry->articles;
        $articles = [];

        foreach(unserialize($reg_articles) as $key => $article_id){
            $article = Article::find($article_id);

            $articles[] = [
                'id' => $article->id, 
                'title' => $article->title, 
                'slug' => $article->slug, 
                'img_src' => $article->img_src, 
                'price' => $article->price,
                'category' => Category::find($article->category_id)
            ];
        }

        // Set array to object
        return array_map(function($array){
                        return (object)$array;
                    }, $articles);
    }
}
