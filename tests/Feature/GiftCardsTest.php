<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\GiftCards;

class GiftCardsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_disable_GiftCards_by_id()
    {
        $response = $this->put('/api/disable-giftcard/15');

        $response->assertStatus(200);
    }

    public function test_wrong_disable_GiftCards_by_id()
    {
        $response = $this->put('/api/disable-giftcard/150');

        $response->assertStatus(500);
    }

    public function test_get_GiftCards_by_id()
    {
        $response = $this->get('/api/giftcard/1');

        $response->assertStatus(200);
    }
    
    public function test_GiftCards_not_found_by_id()
    {
        $response = $this->get('/api/giftcard/10000000');

        $response->assertStatus(404);
    }

    public function test_GiftCards_list()
    {
        $count = GiftCards::get()->count();
        $response = $this->get('/api/giftcards');
        $response->assertJsonCount($count, $key = null);
    }

    public function test_upd_GiftCard(){
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
 
        $response->assertStatus(500);
    }
    
}
