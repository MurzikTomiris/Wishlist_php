<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Accounts;
use App\Helpers\Randomizer;

class AccountTest extends TestCase
{    
    public function test_account_not_found_by_id()
    {
        $latest = Accounts::latest()->first();
        $id = $latest->id+1;
        $response = $this->get('/api/account/' . $id);

        $response->assertStatus(404);
    }

    public function test_get_account_when_id_is_not_numeric()
    {
        $response = $this->get('/api/account/invalid_id');

        $response->assertStatus(404);
    }

    public function test_login()
    {
        $login = Randomizer::generateRandomString(10);
        $existingAccount = Accounts::where("login", $login)->first();
        while ($existingAccount) {
            $login = Randomizer::generateRandomString(10);
            $existingAccount = Accounts::where("login", $login)->first();
        }
        $account = Accounts::factory()->create(['login' => $login]);
        $response = $this->postJson('/api/login', ['login' => $account->login, 'password' => $account->password]);
        $response->assertStatus(200);
        
    }

    public function test_wrong_login()
    {
        $account = Accounts::factory()->make()->toArray();
        $existingAccount = Accounts::where("login", "like", $account["login"])->first();
        while ($existingAccount) {
            $account = Accounts::factory()->make()->toArray();
            $existingAccount = Accounts::where("login", "like", $account["login"])->first();
        }
        $response = $this->postJson('/api/login', $account);
        $response->assertStatus(404);
    }

    public function test_wrong_password()
    {
        $account = Accounts::where("id", 1)->first();
        $password = Randomizer::generateRandomString(1);
        $response = $this->postJson('/api/login', ['login' => $account["login"], 'password' => $password]);

        $response->assertJsonFragment(['message' => 'Неверный логин или пароль']);
    }

    public function test_create_account_email_not_unique()
    {
        $mail = DB::select('select email from accounts where id = 1');
        $email = $mail[0]->email;
        $response = $this->postJson('/api/account', ['login' => 'tomi', 'password' => '1234', 'name' => 'hgtvf', 'email' => $email]);

        $response->assertJsonFragment(['exception' => "Illuminate\\Database\\QueryException"]);
    }

    public function test_create_account()
    {
        $account = Accounts::factory()->create();
        $this->assertModelExists($account);

    }

    public function test_delete_account()
    {
        $account = Accounts::factory()->create();
        $account->delete();
        $this->assertModelMissing($account);

    }

    public function test_delete_account_with_token()
    {
        $account = Accounts::factory()->create();
        $token = $account->token;
        $response = $this->withHeaders([
            'token' => $token,
        ])->delete('/api/account');
        
        $this->assertModelMissing($account);
    }

    public function test_wrong_delete_account()
    {
        $response = $this->withHeaders([
            'token' => null,
        ])->delete('/api/account');
 
        $response->assertUnauthorized();
    }

    public function test_account_list()
    {
        $count = Accounts::get()->count();
        $response = $this->get('/api/accounts');
        $response->assertJsonCount($count, $key = null);
    }

    public function test_upd_account(){
        $latest = Accounts::latest()->first();
        $response = $this->putJson('/api/account/' . $latest->id, ['password' => '500']);
        $response->assertJsonIsObject();     
    }

    public function test_upd_account_wrong_id(){
        $latest = Accounts::latest()->first();
        $id = $latest->id+1;
        $response = $this->putJson('/api/account/' . $id, ['password' => '500']);
        $response->assertJsonFragment(['exception' => "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"]); 
    }
   
}
