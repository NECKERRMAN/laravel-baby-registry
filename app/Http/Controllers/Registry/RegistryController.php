<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use App\Models\Registry;
use Illuminate\Http\Request;

class RegistryController extends Controller
{

    public function index(){
        $user_id = auth()->user()->id;

        return view('registry.registries', [
            'registries' => Registry::all(),
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
