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

    
}
