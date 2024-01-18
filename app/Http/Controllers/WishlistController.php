<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlists;
use App\Models\Accounts;
use App\Helpers\Randomizer;


class WishlistController extends Controller
{

    public function create(Request $request){
        $listLink = Randomizer::generateRandomString(20);
        $wishlist = Wishlists::create(['name' => $request->name, 'description'=> $request->description, 'listLink'=> $listLink, 'AccountId'=> $request->AccountId, 'IsActive' => true]);
        
        return $wishlist;
    }

    public function item($id){
        $wishlist = Wishlists::with(['giftCards'])->find($id);
        return $wishlist;
    }

    public function list(){
        $wishlist = Wishlists::get();
        return $wishlist;
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'description' => 'nullable',
            'listLink' => 'nullable',
            'AccountId'=>'nullable',
            'IsActive' => 'nullable'
        ]);
        $wishlist = Wishlists::find($id)->update($data);
        return $wishlist;
    }

    public function disable($id){
        $wishlist = Wishlists::find($id)->update(['IsActive' => 0]);
        return "Success";
    }
}
