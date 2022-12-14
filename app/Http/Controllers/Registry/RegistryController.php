<?php

namespace App\Http\Controllers\Registry;

use App\Exports\RegistryExport;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

    // Save registry to DB
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
        // Set articles to an empty array
        $registry->articles = [];
        $registry->save();

        return redirect()->route('registry.addArticles', ['id' => $registry->id]);
        
    }

    // edit registry page
    public function editRegistry(Request $req){
        // Get correct registry
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
        // Get all articles and correct registry
        $articles = Article::orderBy('price', 'asc')->paginate(20);
        $registry = Registry::find($req->id);

        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };
        // Get current registry articles
        $current_articles = $registry->articles;
        // Create empty array to store id's -> used to check if already added
        $current_articles_id_array = [];
        // Loop over articles and add id to array
        foreach($current_articles as $article){
            $current_articles_id_array[] = $article['id'];
        };

        // Filters based on get
        if($req->price || $req->category){
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
        
        // Get the added article
        $new_article = Article::findOrFail($req->article_id);
        // Get all articles from the current registry
        $articles = $current_registry->articles;
        // Empy array for id's
        $articles_id = [];
        // Loop over the articles and add id
        foreach($articles as $article){
            $articles_id[] = $article['id'];
        }
        // Check if it's not already added
        if(in_array($new_article->id, $articles_id)){
            return redirect()->route('registry.addArticles', ['id' => $current_registry->id])->withErrors(['msg' => 'Item is already added']);
        }
        // Create JSON object to store in array
        $articles[] = [
            'id' => $new_article->id,
            'name' => $new_article->title,
            // Status 0 -> not bought
            'status' => 0,
            // Ordered by is blank
            "ordered_by" => '-'
        ];
        // Save data to current registry
        $current_registry->articles = $articles;

        $current_registry->updated_at = $current_time->toDateTimeString();
        $current_registry->save();

        return redirect()->route('registry.addArticles', ['id' => $current_registry->id]);

    }

    // Overview of registry articels
    public function showOverview(Request $req){
        $registry = Registry::find($req->id);

        if(!$this->checkAccess($registry)){
            return redirect()->route('home')->with('message', 'PROHIBITED!');
        };
        // Get all registry articles
        $registry_articles = $registry->articles;
        // Empty array to store combined data
        $articles = [];
        // Total price set to 0
        $total = 0;
        // Loop over articles
        foreach($registry_articles as $article){
            $art = Article::find($article['id']);
            // Add full article, status and customer name to array
            $articles[] = [$art, 'status' => $article['status'], 'ordered_by' => $article['ordered_by']];
            // Update total price
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

    // Function for registry visitor
    public function locked(Request $req){
        // Get correct registry
        $reg_slug = $req->slug;
        $registry = Registry::where('slug', '=', $reg_slug)->first();

        // Check if registry is already unlcoked with session
        if($req->session()->get('unlocked') == $registry->id ){
            // Full block incase registry doesn't exist
            if($registry === null) abort(404);
            // Emptry array for articles
            $articles = [];
            if($registry !== null){
                // Get registry articles
                $registry_articles = $registry->articles;
                foreach($registry_articles as $article){
                    $art = Article::find($article['id']);
                    // Add status to articles to check if already bought
                    $articles[] = [$art, 'status' => $article['status']];
                }
            }
            // Initiate cart
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
        
        return view('registry.locked')->with(compact('registry'));
    }
    
    public function unlocked(Request $req){
        // Find registry from form
        $registry = Registry::findOrFail($req->reg_id);
        // Check password
        if($req->secret_password === $registry->password){
            // Add correct id to session
            session(['unlocked' => $req->reg_id]);
            if($registry === null) abort(404);
            // Empty array to fill articles
            $articles = [];
            if($registry !== null){ 
                // Fill articles with article and article status
                $registry_articles = $registry->articles;
                foreach($registry_articles as $article){
                    $art = Article::find($article['id']);
                    // Status to check if already bougt
                    $articles[] = [$art, 'status' => $article['status']];
                }
            }
            //Initiate Cart
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
        } else {
            return redirect()->back();
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

         // Total price set to 0
         $total = 0;
        // Get the updated array for the view
        $updated = [];
        foreach($current_articles as $article){
            $art = Article::find($article['id']);
            $updated[] = [$art, 'status' => $article['status'], 'ordered_by' => $article['ordered_by']];
            // Update total price
            if($article['status'] === 1 ){
            $total += $art->price;
            }
        }

        return view('registry.overview', [
            'registry' => $registry,
            'articles' => $updated,
            'total' => $total
        ]);
    }
    // Export requested registry data (articles, who bought, store, price)
    public function export(Request $req){
        // Find correct registry
        $registry = Registry::findOrFail($req->registry);
        return Excel::download(new RegistryExport($registry), $registry->name . '.xlsx');
    }
}
