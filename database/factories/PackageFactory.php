<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => 'package-' . $this->faker->lexify('?????'),
            'limit' => $this->faker->numberBetween(3, 8),
        ];
    }
}
