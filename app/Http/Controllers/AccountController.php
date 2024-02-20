<?php

namespace App\Http\Controllers;
use App\Models\Accounts;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create(Request $request){
        $account = Accounts::create(['login' => $request->login, 'password'=> $request->password, 'name'=> $request->name, 'email'=> $request->email]);
        return $account;
    }

    public function item($id){
        $account = Accounts::with(['wishlists'])->findOrFail($id);
        return $account;
    }

    public function list(){
        $account = Accounts::get();
        return $account;
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'login' => 'nullable',
            'password'=> 'nullable',
            'name'=> 'nullable',
            'email' => 'nullable',
            'token' => 'nullable'
        ]);
        $account = Accounts::find($id);
        $account->update($data);
        return $account;
    }

    public function delete($id){
        $account = Accounts::find($id);
        $account->delete();
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
