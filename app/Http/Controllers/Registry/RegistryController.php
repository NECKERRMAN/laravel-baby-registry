<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Registry;
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

    public function editRegistry(Registry $registry){
        dd('edit');
    }

    public function allArticles(Request $req){
        $registry = Registry::find($req->id);
        $articles = Article::orderBy('price', 'asc')->get();
        $current_articles = [];

        // Check if user has acces
        if(auth()->user()->id !== $registry->user_id){
            return redirect()->back();
        }
        return view('registry.items', [
            'registry' => $registry,
            'articles' => $articles,
            'current_articles' => $current_articles,
            'categories' => Category::all()
        ]);
    }
    
    public function addArticle(Request $req){
        dd($req);
    }
    
    public function filterArticles(Request $req){
        $category_id = '';
        $articles = '';
        $registry = Registry::find($req->id);

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
            'categories' => Category::all()
        ]);
    }

    public function locked(){
        return view('registry.locked');
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
}
