<?php

namespace App\Services;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class WishlistService
{
    public function list($accountId){
        $wishlist = Wishlists::where('AccountId', 'like', $accountId)
                                ->where('IsActive', true)
                                ->get();
        return $wishlist;
    }

    public function getIdByLink($listLink){
        $wishlist = Wishlists::where('listLink', 'like', $listLink)
                                ->where('IsActive', true)
                                ->with(['giftCards' => function ($query) {
                                    $query->where('IsActive', true);
                                }])
                                ->first();
        return $wishlist;
    }

    public function create($data, $accountId){

        $listLink = Randomizer::generateRandomString(20);
        $data["AccountId"] = $accountId;
        $data["listLink"] = $listLink;
        $data["IsActive"] = true;
        $wishlist = Wishlists::create($data);
        
        return $wishlist;
    }

    public function item($id){
        $wishlist = Wishlists::with(['giftCards'])->findOrFail($id);

        return $wishlist;
    }

    public function update($data, $id)
    {
        $wishlist = Wishlists::find($id)->update($data);

        return $wishlist;
    }

    public function disable($id){
        $wishlist = Wishlists::find($id)->update(['IsActive' => 0]);
        return true;
    }
}