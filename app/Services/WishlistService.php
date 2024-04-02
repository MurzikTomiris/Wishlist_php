<?php

namespace App\Services;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class WishlistService
{
    public function list(Accounts $account){
        $wishlist = Wishlists::where('AccountId', $account->id)
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
}