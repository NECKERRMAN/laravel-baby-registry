<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use App\Models\Registry;
use Illuminate\Http\Request;

class RegistryController extends Controller
{

    public function index(){
        $user_id = auth()->user()->id;
        $allRegistries = Registry::find($user_id);

        dd($allRegistries);
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
