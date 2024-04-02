<?php

namespace App\Http\Controllers;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Services\AccountService;
use App\Helpers\Randomizer;
use App\Http\Requests\AccountRequest;


use Illuminate\Http\Request;

class AccountController extends Controller
{

    protected $service;

    public function __construct(){
        $this->service = new AccountService();
    }

    public function create(AccountRequest $request){
        
        $request['token'] = Randomizer::generateRandomString(50);
        $account = Accounts::create($request->all());
        return $account;
    }

    public function item(Request $request){
        //$account = Accounts::with(['wishlists'])->findOrFail($id);
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

        $data = $request->all();

        return $this->service->update($token, $data);
    }

    public function delete(Request $request){
        $token = $request->header('token');
        $this->service->delete($token);
        return "Success";
    }

    public function login(Request $request){
        $account = Accounts::where("login", "like", $request->login)->firstOrFail();
        if($account->password == $request->password){
            $token = Randomizer::generateRandomString(50);
            $account->update(['token' => $token]);
            return response()->json(['token' => $token], 200);
        }
        else{
            throw new \Exception("Неверный логин или пароль");
        }
    }
}


// php artisan make:request
// созать папку