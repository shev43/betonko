<?php

namespace Database\Factories;

use App\Models\BusinessFactories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $latestEntry = BusinessFactories::get();

        return [
            'business_id' => random_int(1, 5),
            'factory_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'name' => $this->faker->company(),
            'address' => $this->faker->streetAddress(),
        ];

    }
}
