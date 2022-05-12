<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class addStoreController extends Controller
{
    public function addStore(Request $req){
        $store = new Store();
        $store->name = $req->storeName;
        $store->store_key = $req->storeKey;
        $store->street = $req->street;
        $store->zip_code = $req->zipcode;
        $store->city = $req->city;
        $store->save();
    }
}
