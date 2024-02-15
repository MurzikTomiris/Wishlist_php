<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishlistTest extends TestCase
{
   
    public function test_create_wishlist()
    {
        $account = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '123'])->getContent();
        $obj=json_decode($account);
        $token = $obj->token;
        $response = $this->withHeaders([
            'token' => $token,
        ])->postJson('/api/wishlist', ['name' => 'ноут', 'description' => 'озу 24 гб']);
 
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


}
