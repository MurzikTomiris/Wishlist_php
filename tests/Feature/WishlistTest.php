<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Wishlists;

class WishlistTest extends TestCase
{
   
    public function test_create_wishlist()
    {
        $account = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '500'])->getContent();
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

    public function test_unautorized_create_wishlist()
    {
        $response = $this->withHeaders([
            'token' => null,
        ])->postJson('/api/wishlist', ['name' => 'ноут', 'description' => 'озу 24 гб']);
 
        $response->assertUnauthorized();
    }

    public function test_disable_by_id()
    {
        $response = $this->put('/api/disable-wishlist/15');

        $response->assertStatus(200);
    }

    public function test_wrong_disable_by_id()
    {
        $response = $this->put('/api/disable-wishlist/10000000');

        $response->assertStatus(500);
    }

    public function test_get_GiftCards_by_id()
    {
        $response = $this->get('/api/wishlist/1');

        $response->assertStatus(200);
    }
    
    public function test_GiftCards_not_found_by_id()
    {
        $response = $this->get('/api/wishlist/10000000');

        $response->assertStatus(404);
    }

    public function test_wishlists_list()
    {
        $count = Wishlists::get()->count();
        $response = $this->get('/api/wishlists');
        $response->assertJsonCount($count, $key = null);
    }

    public function test_upd_wishlist(){
        $response = $this->putJson('/wishlist/4', ['description' => '8 March wishlist']);
        $response->assertJsonIsObject();     
    }

    public function test_upd_wishlist_wrong_id(){
        $response = $this->putJson('/wishlist/100000000', ['description' => 'New year wishlist']);
        $response->assertJsonFragment(['exception' => "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"]); 
    }

    
}
