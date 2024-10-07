<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RegisterPackageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_for_an_available_package()
    {
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer, ['*']);

        $package = Package::factory()->create(['limit' => 5]);

        $response = $this->postJson('/api/packages/register', [
            'customer_id' => $customer->id,
            'package_id' => $package->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_registration_fails_if_package_is_unavailable()
    {
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer, ['*']);

        $package = Package::factory()->create(['limit' => 1]);
        $package->registrations()->create([
            'uuid' => (string) Str::uuid(),
            'customer_id' => $customer->id,
            'registered_at' => now(),
        ]);

        $response = $this->postJson('/api/packages/register', [
            'customer_id' => $customer->id,
            'package_id' => $package->id,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => __('app.package_not_available_registration')]);
    }
}
