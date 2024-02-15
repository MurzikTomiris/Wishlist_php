<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    
    public function test_get_by_id()
    {
        $response = $this->get('/api/account/4');

        $response->assertStatus(200);
    }
    
    public function test_not_found_by_id()
    {
        $response = $this->get('/api/account/41000');

        $response->assertStatus(404);
    }

    public function test_login()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '123']);

        $response->assertStatus(200);
    }

    public function test_wrong_login_or_password()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom', 'password' => '123']);

        $response->assertJsonFragment(['message' => 'No query results for model [App\\Models\\Accounts].']);
    }

    public function test_wrong_password()
    {
        $response = $this->postJson('/api/login', ['login' => 'tom1', 'password' => '1123']);

        $response->assertJsonFragment(['message' => 'Неверный логин или пароль']);
    }
}
