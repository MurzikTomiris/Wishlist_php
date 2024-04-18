<?php

namespace App\Services;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class AccountService
{
    public function item($token){
        $account = Accounts::where('token', 'like', $token)->firstOrFail(); 
        
        return $account;
    }

    public function update($token, $data){
        $account = $this->item($token);
        $account->update($data);

        return $account;
    }

    public function delete($token){
        $account = $this->item($token);
        $account->delete();

        return true;
    }

    public function create($data){
        
        $data['token'] = Randomizer::generateRandomString(50);
        $account = Accounts::create($data);

        return $account;
    }

    public function login($data){
        $account = Accounts::where("login", "like", $data["login"])->firstOrFail();
        if($account->password == $data["password"]){
            $token = Randomizer::generateRandomString(50);
            $account->update(['token' => $token]);
            return $token;
        }
        else {
            throw new \Exception("Неверный логин или пароль");
        }
    }
}