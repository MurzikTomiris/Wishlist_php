<?php

namespace App\Http\Controllers;
use App\Models\Wishlists;
use App\Models\GiftCards;

use Illuminate\Http\Request;

class GiftCardsController extends Controller
{
    public function create(Request $request){
        $giftCard = GiftCards::create([
            'title' => $request->title, 
            'description'=> $request->description, 
            'price'=> $request->price, 
            'link'=> $request->link,
            'image'=> $request->image,
            'wishlist_id'=> $request->wishlist_id
        ]);

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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'price' => 'nullable', 
            'link' => 'nullable',
            'image' => 'nullable',
            'wishlist_id' => 'nullable',
            'IsReserved'=>'nullable',
            'IsActive' => 'nullable'
        ]);

        $giftCard = GiftCards::find($id)->update($data);
        return $giftCard;
    }

    public function disable($id){
        $giftCard = GiftCards::find($id)->update(['IsActive' => 0]);
        return "Success";
    }
}
