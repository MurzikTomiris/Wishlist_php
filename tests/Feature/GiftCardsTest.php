<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\GiftCards;
use App\Models\Wishlists;
use App\Helpers\Randomizer;

class GiftCardsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_disable_GiftCards_by_id()
    {
        $latest = GiftCards::latest()->first();

        $response = $this->put('/api/disable-giftcard/' .$latest->id);

        $response->assertStatus(200);
    }

    public function test_wrong_disable_GiftCards_by_id()
    {
        $latest = GiftCards::latest()->first();
        $id = $latest->id+1;
        $response = $this->put('/api/disable-giftcard/' .$id);

        $response->assertStatus(500);
    }

    public function test_get_GiftCards_by_id()
    {
        $first = GiftCards::first();
        $response = $this->get('/api/giftcard/' .$first->id);

        $response->assertStatus(200);
    }
    
    public function test_giftCards_not_found_by_id()
    {
        $latest = GiftCards::latest()->first();
        $id = $latest->id+1;
        $response = $this->get('/api/giftcard/' .$id);

        $response->assertStatus(404);
    }

    public function test_get_giftCards_when_id_is_not_numeric()
    {
        $response = $this->get('/api/giftcard/invalid_id');

        $response->assertStatus(500);
    }

    public function test_GiftCards_list()
    {
        $count = GiftCards::get()->count();
        $response = $this->get('/api/giftcards');

        $response->assertJsonCount($count, $key = null);
    }

    public function test_upd_GiftCard()
    {

        $response = $this->putJson('/giftcard/34', ['description' => 'white']);

        $response->assertJsonIsObject();     
    }

    public function test_upd_giftCard_wrong_id(){
        $response = $this->putJson('/giftcard/100000000', ['description' => 'white']);
        
        $response->assertJsonFragment(['exception' => "Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"]); 
    }

    public function test_create_GiftCard()
    {
        $giftCard = GiftCards::factory()->create();

        $this->assertModelExists($giftCard);
    }

    public function test_create_GiftCard_wrong_id()
    {
        $response = $this->postJson('/api/giftcard', ['title' => 'IPhine', 'description' => '15 pro', 'wishlist_id' => '1000000000']);
 
        $response->assertStatus(404);
    }

    public function test_create_card_title_error()
    {
        $title = Randomizer::generateRandomString(200);
        $response = $this->postJson('/api/giftcard', ['title' => $title, 'description' => '15 pro', 'wishlist_id' => '1000000000']);
 
        $response->assertStatus(422);
    }

    public function test_create_card_title_max()
    {
        $title = Randomizer::generateRandomString(200);
        $response = $this->postJson('/api/giftcard', ['title' => $title, 'description' => '15 pro', 'wishlist_id' => '1000000000']);
 
        $response->assertJsonFragment(['message' => 'The title must not be greater than 100 characters.']);
    }

    public function test_get_GiftCards_listById()
    {
        $latest = Wishlists::latest()->first();
        $response = $this->get('/api/giftcards/' .$latest->id);

        $response->assertStatus(200);
    }
    
    public function test_GiftCards_not_found_listById()
    {
        $latest = Wishlists::latest()->first();
        $id = $latest->id+1;
        $response = $this->get('/api/giftcards/' .$id);

        $response->assertJson([]);
    }
}
