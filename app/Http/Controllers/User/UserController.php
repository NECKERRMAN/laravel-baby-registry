<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   
    // See current user details
    public function showUserDetails(){
        $user = Auth::user();
        dd($user);
    }

    // User can delete own registries
    public function deleteRegistry(Request $req){

        $registry = Registry::find($req->registry_id);

        // Extra safety, check if current user can delete
        if($registry->user_id === Auth::user()->id){
            Registry::find($req->registry_id)->delete();
            return redirect()->route('registry.all');
        } else {            
            return redirect()->route('registry.all');
        }
    }
}
