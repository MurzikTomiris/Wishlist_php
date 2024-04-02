<?php

namespace App\Services;
use App\Models\GiftCards;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class GiftCardsService
{
    public function create($data){
        $wishlists = Wishlists::where("id", "=", $data['wishlist_id'])->firstOrFail();
            $giftCard = GiftCards::create($data);
            return $giftCard;
    }

    public function listById($id){
        $giftCard = GiftCards::where('wishlist_id', $id)
                            ->where('IsActive', true)
                            ->get();
        return $giftCard;
    }

    public function item($id){
        $giftCard = GiftCards::with(['wishlist'])->findOrFail($id);
        return $giftCard;
    }

    public function list(){
        $giftCard = GiftCards::get();
        return $giftCard;
    }

    public function update($data, $id)
    {
        $giftCard = GiftCards::find($id)->update($data);
        return $giftCard;
    }

    public function disable($id){
        $giftCard = GiftCards::find($id)->update(['IsActive' => 0]);
        return "Success";
    } 
}