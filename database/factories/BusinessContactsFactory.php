<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessContactsFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_id' => random_int(1, 5),
            'name' => $this->faker->name(),
            'phone' => $this->faker->e164PhoneNumber(),
            'position' => $this->faker->word(),
        ];
    }
}
