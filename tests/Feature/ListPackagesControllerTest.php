<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListPackagesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_packages()
    {
        $customer = Customer::factory()->create();
        Sanctum::actingAs($customer, ['*']);

        Package::factory()->count(5)->create();

        $response = $this->getJson('/api/packages');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'name', 'limit', 'availability']]]);
    }
}
