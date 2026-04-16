<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_page_status_code(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_create_new_user(): void
    {
        $data = [
            "email" => "test@test.com",
            "password" => "123456789",
            "name" => "test"
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
    }
}
