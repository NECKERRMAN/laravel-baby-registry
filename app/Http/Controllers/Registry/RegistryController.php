<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

use function PHPUnit\Framework\isEmpty;

class RegistryController extends Controller
{
    // Overview user's registries
    public function index(){
        $user_id = auth()->user()->id;
        $user_registries = Registry::where('user_id', '=', $user_id)->get();
        return view('registry.registries', [
            'registries' => $user_registries,
        ]);

    }

    // Check if current user has access to registry
    private function checkAccess($registry){
        // Check if user has acces
        if(Auth::user()->id !== $registry->user_id){
            return false;
        } else {
            return true;
        }
    }

    // Create new registry
    public function new(){
        return view('registry.create');
    }

    // Save registry
    public function createRegistry(Request $req){
        $user_id = $req->user_id;
        // Unique slug for the list babyname + userID + birthdate
        // Incase user adds space to babyName
        $baby_name = strtolower(str_replace(' ', '-', $req->babyName));
        $slug = $baby_name . '-' . $user_id . '-' . $req->birthdate;

        $registry = new Registry();
        $registry->user_id = $user_id;
        $registry->name = $req->registryName;
        $registry->baby_name = $req->babyName;
        $registry->birthdate = $req->birthdate;
        $registry->slug = $slug;
        $registry->password = $req->password_registry;
        $registry->articles = [];
        $registry->save();

        return redirect()->route('registry.addArticles', ['id' => $registry->id]);
        
    }

    // edit registry page
    public function editRegistry(Request $req){
        
        $registry = Registry::findOrFail($req->id);

        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };

        return view('registry.edit')->with(compact('registry'));
    }

    // Update the edited registry
    public function update(Request $req){
        $user_id = $req->user_id;
        // Unique slug for the list babyname + userID + birthdate
        // Incase user adds space to babyName
        $baby_name = strtolower(str_replace(' ', '-', $req->babyName));
        $slug = $baby_name . '-' . $user_id . '-' . $req->birthdate;
        $currentTime = Carbon::now();

        $registry = Registry::findOrFail($req->id);
        $registry->user_id = $user_id;
        $registry->name = $req->registryName;
        $registry->baby_name = $req->babyName;
        $registry->birthdate = $req->birthdate;
        $registry->slug = $slug;
        $registry->password = $req->password_registry;
        $registry->updated_at = $currentTime->toDateTimeString();
        $registry->save();

        return view('registry.edit')->with(compact('registry'))->with('success', ucfirst(__('updated')) . '!');
    }

    // Get all articles
    public function allArticles(Request $req){
        $articles = Article::orderBy('price', 'asc')->paginate(20);
        $registry = Registry::find($req->id);

        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };

        $current_articles = $registry->articles;
        $current_articles_id_array = [];

        foreach($current_articles as $article){
            $current_articles_id_array[] = $article['id'];
        };

        if($req->price && $req->category){
                // Filter on category
            if($req->category !== '0'){
                $category_id = $req->category;
                // Filter on price
                if($req->price === 'high-low'){
                    $articles = Article::where('category_id', '=', $category_id)
                        ->orderBy('price', 'desc')
                        ->paginate(20);
                } else {
                    $articles = Article::where('category_id', '=', $category_id)
                    ->orderBy('price', 'asc')
                    ->paginate(20);
                }
            } else {
                if($req->price === 'high-low'){
                    $articles = Article::orderBy('price', 'desc')->paginate(20);
                } else {
                    $articles = Article::orderBy('price', 'asc')->paginate(20);
                }
            }
        }
        

        return view('registry.items', [
            'registry' => $registry,
            'articles' => $articles,
            'current_articles' => $current_articles,
            'id_array' => $current_articles_id_array,
            'categories' => Category::all()
        ]);
    }

    // Add article to wishlist
    public function addArticle(Request $req){
        $current_registry = Registry::findOrFail($req->reg_id);
        $current_time = Carbon::now();

        if(!$this->checkAccess($current_registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };
        
        $new_article = Article::findOrFail($req->article_id);

        $articles = $current_registry->articles;
        $articles_id = [];

        foreach($articles as $article){
            $articles_id[] = $article['id'];
        }

        if(in_array($new_article->id, $articles_id)){
            return redirect()->route('registry.addArticles', ['id' => $current_registry->id])->withErrors(['msg' => 'Item is already added']);
        }

        $articles[] = [
            'id' => $new_article->id,
            'name' => $new_article->title,
            'status' => 0
        ];

        $current_registry->articles = $articles;

        $current_registry->updated_at = $current_time->toDateTimeString();
        $current_registry->save();

        return redirect()->route('registry.addArticles', ['id' => $current_registry->id]);

    }

    public function showOverview(Request $req){
        $registry = Registry::find($req->id);

        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };
        $registry_articles = $registry->articles;

        $articles = [];
        $total = 0;
        foreach($registry_articles as $article){
            $art = Article::find($article['id']);

            $articles[] = [$art, 'status' => $article['status']];
            if($article['status'] === 1 ){
                $total += $art->price;
            }
        }

        return view('registry.overview', [
                'registry' => $registry,
                'articles' => $articles,
                'total' => $total
        ]);
    }

    public function locked(Request $req){
        $reg_slug = $req->slug;
        $registry = Registry::where('slug', '=', $reg_slug)->first();
        if($registry === null) abort(404);
        $articles = [];
        if($registry !== null){

            $registry_articles = $registry->articles;
            foreach($registry_articles as $article){
                $art = Article::find($article['id']);
                $articles[] = [$art, 'status' => $article['status']];
            }
        }

        $cart = Cart::session(1);
        $cart_array = [];
        foreach($cart->getContent() as $key => $value){
            $cart_array[] = $key;
        }

        return view('registry.visitor', [
                'registry' => $registry,
                'articles' => $articles,
                'cart_array' => $cart_array,
                'cart' => $cart
        ]);
    }
    
    public function unlocked(Request $req){
        $reg_slug = $req->slug;
        $registry = Registry::where('slug', '=', $reg_slug)->first();

        if($req->secret_password === $registry->password){
            $reg_slug = $req->slug;
            $registry = Registry::where('slug', '=', $reg_slug)->first();
            $articles = [];
            if($registry !== null){
    
                $registry_articles = $registry->articles;
                foreach($registry_articles as $article){
                    $art = Article::find($article['id']);
                    $articles[] = [$art, 'status' => $article['status']];
                }
            }
    
            $cart = Cart::session(1);
            $cart_array = [];
            foreach($cart->getContent() as $key => $value){
                $cart_array[] = $key;
            }
    
            return view('registry.visitor', [
                    'registry' => $registry,
                    'articles' => $articles,
                    'cart_array' => $cart_array,
                    'cart' => $cart
            ]);
        }
    }

    // Delete specific article from registry
    public function deleteRegistryArticle(Request $req){
        // Get Registry and Article Id
        $registry = Registry::findOrFail($req->id);
        // Get current date with carbon
        $current_time = Carbon::now();

        // CHeck users access
        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };

        $article_id = $req->article_id;
        // Get the current Articles
        $current_articles = $registry->articles;
        // Loop over current articles and find the article_id
        foreach($current_articles as $key => $article){
            foreach($article as $valueKey => $value){
                if($valueKey == 'id' && $value == $article_id){
                    // delete the article
                    unset($current_articles[$key]);
                }
            }
        }

        // Save new array of articles
        $registry->articles = $current_articles;

        $registry->updated_at = $current_time->toDateTimeString();
        $registry->save();
        // Get the updated array for the view
        $updated = [];

        foreach($current_articles as $article){
            $art = Article::find($article['id']);

            $updated[] = [$art, 'status' => $article['status']];

        }

        return view('registry.overview', [
            'registry' => $registry,
            'articles' => $updated
        ]);

    }

    /* TO BE REMOVED */
    private function getRegistryArticles($registry){
        $reg_articles = $registry->articles;
        $articles = [];

        foreach(unserialize($reg_articles) as $key => $article_id){
                $article = Article::find($article_id);

                if($article !== null){
                    $articles[] = [
                        'id' => $article->id, 
                        'title' => $article->title, 
                        'slug' => $article->slug, 
                        'img_src' => $article->img_src, 
                        'price' => $article->price,
                        'category' => Category::find($article->category_id)
                    ];
                }

        }

        // Set array to object
        return array_map(function($array){
                        return (object)$array;
                    }, $articles);
    }
}
