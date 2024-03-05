<?php

namespace App\Services;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class AccountService
{
    public function item($token){
        $account = Accounts::where('token', 'like', $token)->first(); 
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
}