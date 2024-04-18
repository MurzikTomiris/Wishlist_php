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

    public function create(WishlistRequest $request){

        $token = $request->header('token');
        $account = $this->accountService->item($token);
        $wishlist = $this->service->create($request->all(), $account->id);
        
        return $wishlist;
    }

    public function item($id){
        $wishlist = $this->service->item($id);

        return $wishlist;
    }

    public function list(Request $request){
        $token = $request->header('token');
        $account = $this->accountService->item($token);
        $wishlist = $this->service->list($account->id);

        return $wishlist;
    }

    public function listByLink($listLink){
        $wishlist = $this->service->getIdByLink($listLink);

        return $wishlist;
    }

    public function update(WishlistRequest $request, $id)
    {
        $wishlist = $this->service->update($request->all(), $id);

        return $wishlist;
    }

    public function disable($id){
        $wishlist = $this->service->disable($id);
        
        return true;
    }
}
