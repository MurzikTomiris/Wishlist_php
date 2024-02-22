<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accounts;

class AccountTest extends TestCase
{
    
    public function test_get_account_by_id()
    {
        $response = $this->get('/api/account/4');

        $response->assertStatus(200);
    }
    
    public function test_account_not_found_by_id()
    {
        $response = $this->get('/api/account/41000');

        $response->assertStatus(404);
    }

    public function test_login()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '500']);

        $response->assertStatus(200);
    }

    public function test_wrong_login()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom', 'password' => '123']);

        $response->assertJsonFragment(['message' => 'No query results for model [App\\Models\\Accounts].']);
    }

    public function test_wrong_password()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '1123']);

        $response->assertJsonFragment(['message' => 'Неверный логин или пароль']);
    }

    public function test_create_account__email_not_unique()
    {
        $response = $this->postJson('/api/account', ['login' => 'tomi', 'password' => '1234', 'name' => 'hgtvf', 'email' => '1234@hghj.dw']);

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

    public function test_account_list()
    {
        $count = Accounts::get()->count();
        $response = $this->get('/api/accounts');
        $response->assertJsonCount($count, $key = null);
    }

    public function test_upd_account(){
        $response = $this->putJson('/account/34', ['password' => '500']);
        $response->assertJsonIsObject();     
    }

    public function test_upd_account_wrong_id(){
        $response = $this->putJson('/account/1000000', ['password' => '500']);
        $response->assertJsonFragment(['exception' => "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"]); 
    }

    public function test_get_account_by_id_when_id_is_not_numeric()
    {
        $response = $this->get('/api/account/invalid_id');

        $response->assertStatus(500);
    }

    public function test_account_has_no_wishlists()
    {
        $account = Accounts::factory()->create();

        $response = $this->get("/api/account/{$account->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $account->id,
                     'wishlists' => []
                 ]);
    }
}
