<?php

namespace App\Http\Controllers;
use App\Models\Wishlists;
use App\Models\GiftCards;
use App\Http\Requests\GiftCardRequest;
use App\Services\GiftCardsService;


use Illuminate\Http\Request;

class GiftCardsController extends Controller
{
    protected $service;

    public function __construct(){
        $this->service = new GiftCardsService();
    }

    public function create(GiftCardRequest $request){
        $giftCard = $this->service->create($request->all());
        return $giftCard;
    }

    public function item($id){
        $giftCard = $this->service->item($id);
        return $giftCard;
    }

    public function list(){
        $giftCard = $this->service->list();
        return $giftCard;
    }

    public function listById($id){
        $giftCard = $this->service->listById($id);
        return $giftCard;
    }


    public function update(GiftCardRequest $request, $id)
    {
        $giftCard = $this->service->update($request->all(), $id);
        return $giftCard;
    }

    public function disable($id){
        $giftCard = $this->service->disable($id);
        return "Success";
    }  
}
