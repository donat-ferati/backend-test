<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_login_successfully()
    {
        $customer = Customer::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'user' => ['id', 'name', 'email'],
                    'token',
                ],
            ])->assertJson(['data' => ['type' => 'customer']]);
    }

    public function test_user_can_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'user' => ['id', 'name', 'email'],
                    'token',
                ],
            ])->assertJson(['data' => ['type' => 'user']]);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        Customer::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'customer@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => __('auth.failed')]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => __('auth.failed')]);
    }
}
