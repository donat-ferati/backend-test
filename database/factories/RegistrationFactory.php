<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'customer_id' => Customer::factory(),
            'package_id' => Package::factory(),
            'registered_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
