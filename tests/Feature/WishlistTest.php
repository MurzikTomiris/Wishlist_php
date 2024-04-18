<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Wishlists;
use App\Models\Accounts;
use App\Helpers\Randomizer;

class WishlistTest extends TestCase
{
   
    public function test_create_wishlist()
    {
        $accountInfo = Accounts::where("id", 1)->first();
        $account = $this->postJson('/api/login', ['login' => $accountInfo->login, 'password' => $accountInfo->password])->getContent();
        $obj=json_decode($account);
        $token = $obj->token;
        $response = $this->withHeaders([
            'token' => $token,
        ])->postJson('/api/wishlist', ['name' => 'Birthday wishlist', 'description' => 'Birthday wishlist']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                'IsActive' => true,
            ]);
    }

    public function test_create_wishlist_name_error()
    {
        $accountInfo = Accounts::where("id", 1)->first();
        $account = $this->postJson('/api/login', ['login' => $accountInfo->login, 'password' => $accountInfo->password])->getContent();
        $obj=json_decode($account);
        $token = $obj->token;
        $name = Randomizer::generateRandomString(200);
        $response = $this->withHeaders([
            'token' => $token,
        ])->postJson('/api/wishlist', ['name' => $name, 'description' => 'Birthday wishlist']);
 
        $response->assertStatus(422);
    }

    public function test_create_wishlist_name_max()
    {
        $accountInfo = Accounts::where("id", 1)->first();
        $account = $this->postJson('/api/login', ['login' => $accountInfo->login, 'password' => $accountInfo->password])->getContent();
        $obj=json_decode($account);
        $token = $obj->token;
        $name = Randomizer::generateRandomString(200);
        $response = $this->withHeaders([
            'token' => $token,
        ])->postJson('/api/wishlist', ['name' => $name, 'description' => 'Birthday wishlist']);
 
        $response->assertJsonFragment(['message' => 'The name must not be greater than 100 characters.']);
    }


    public function test_unautorized_create_wishlist()
    {
        $response = $this->withHeaders([
            'token' => null,
        ])->postJson('/api/wishlist', ['name' => 'ноут', 'description' => 'озу 24 гб']);
 
        $response->assertUnauthorized();
    }

    public function test_disable_by_id()
    {
        $latest = Wishlists::latest()->first();
        $response = $this->put('/api/disable-wishlist/' . $latest->id);

        $response->assertStatus(200);
    }

    public function test_wrong_disable_by_id()
    {
        $latest = Wishlists::latest()->first();
        $id = $latest->id+1;
        $response = $this->put('/api/disable-wishlist/' . $id);

        $response->assertStatus(500);
    }

    public function test_upd_wishlist(){
        $response = $this->putJson('/wishlist/4', ['description' => '8 March wishlist']);
        $response->assertJsonIsObject();     
    }

    public function test_upd_wishlist_wrong_id(){
        $response = $this->putJson('/wishlist/100000000', ['description' => 'New year wishlist']);
        $response->assertJsonFragment(['exception' => "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"]); 
    }

    public function test_wishlist_get_by_id()
    {
        $latest = Wishlists::latest()->first();
        $response = $this->get('/api/wishlist/' .$latest->id);

        $response->assertStatus(200);
    }

    public function test_wishlist_not_found_by_id()
    {
        $latest = Wishlists::latest()->first();
        $id = $latest->id+1;
        $response = $this->get('/api/wishlist/' . $id);

        $response->assertStatus(404);
    }

    public function test_get_by_id_when_id_is_not_numeric()
    {
        $response = $this->get('/api/wishlist/invalid_id');

        $response->assertStatus(500);
    }

    public function test_wishlist_link()
    {
        $wishlist = Wishlists::where("id", 1)->first();

        $response = $this->get('/api/wishlist-link/' .$wishlist->listLink);

        $response->assertStatus(200);
    }
    
}
