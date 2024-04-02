<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlists;
use App\Models\Accounts;
use App\Helpers\Randomizer;
use App\Services\AccountService;
use App\Services\WishlistService;
use App\Http\Requests\WishlistRequest;



class WishlistController extends Controller
{
    protected $service;
    protected $accountService;

    public function __construct(){
        $this->service = new WishlistService();
        $this->accountService = new AccountService();
    }

    public function create(Request $request){

        $token = $request->header('token');
        $account = $this->accountService->item($token);
        $AccountId = $account->id;
        $listLink = Randomizer::generateRandomString(20);
        $wishlist = Wishlists::create(['name' => $request->name, 'description'=> $request->description, 'listLink'=> $listLink, 'AccountId'=> $AccountId, 'IsActive' => true]);
        
        return $wishlist;
    }

    public function item($id){
        $wishlist = Wishlists::with(['giftCards'])->findOrFail($id);
        return $wishlist;
    }

    public function list(Request $request){
        $token = $request->header('token');
        $account = $this->accountService->item($token);
        $wishlist = $this->service->list($account);
        return $wishlist;
    }

    public function listByLink($listLink){
        $wishlist = $this->service->getIdByLink($listLink);
        return $wishlist;
    }

    public function update(WishlistRequest $request, $id)
    {
        $data = $request->all();
        $wishlist = Wishlists::find($id)->update($data);
        return $wishlist;
    }

    public function disable($id){
        $wishlist = Wishlists::find($id)->update(['IsActive' => 0]);
        return "Success";
    }
}
