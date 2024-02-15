<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GiftCardsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_disable_by_id()
    {
        $response = $this->put('/api/disable-giftcard/15');

        $response->assertStatus(200);
    }

    public function test_wrong_disable_by_id()
    {
        $response = $this->put('/api/disable-giftcard/150');

        $response->assertStatus(500);
    }
}
