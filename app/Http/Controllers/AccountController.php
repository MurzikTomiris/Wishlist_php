<?php

namespace App\Http\Controllers;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Services\AccountService;
use App\Helpers\Randomizer;
use App\Http\Requests\AccountRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{

    protected $service;

    public function __construct(){
        $this->service = new AccountService();
    }

    public function create(AccountRequest $request){
        
        $account = $this->service->create($request->all());

        return response()->json($account, 201);
    }

    public function item(Request $request){
        $token = $request->header('token');

        return $this->service->item($token);
    }

    public function list(){
        $account = Accounts::get();

        return $account;
    }

    public function update(AccountRequest $request)
    {
        $token = $request->header('token');

        return $this->service->update($token, $request->all());
    }

    public function delete(Request $request){
        $token = $request->header('token');
        $this->service->delete($token);
        
        return true;
    }

    public function login(AccountRequest $request){
        Log::info($request->all());
        $token = $this->service->login($request->all());
        
        return response()->json(['token' => $token], 200);
    }
}

