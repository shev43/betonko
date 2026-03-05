<?php

namespace Database\Factories;

use App\Models\BusinessProducts;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $products = [
            'mark' => ['100', '150', '200', '250', '350', '400', '450', '500', '700', '800'],
            'class' => ['b7', 'b12', 'b15', 'b20', 'b25', 'b30', 'b35', 'b40', 'b50', 'b55'],
            'frost_resistance' => ['f50', 'f100', 'f150', 'f200', 'f300', 'f400', 'f600', 'f800', 'f1000'],
            'water_resistance' => ['w2', 'w4', 'w6', 'w8', 'w10'],
            'mixture_mobility' => ['s1', 's2', 's3', 's4', 's5'],
            'winter_supplement' => ['without', 'hot_water', 'm5', 'm10', 'm15']
        ];

        $latestEntry = BusinessProducts::get();

        return [
            'business_id' => random_int(1, 5),
            'product_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'mark' => $this->faker->randomElement($products['mark']),
            'class' => $this->faker->randomElement($products['class']),
            'water_resistance' => $this->faker->randomElement($products['water_resistance']),
            'winter_supplement' => $this->faker->randomElement($products['winter_supplement']),
            'mixture_mobility' => $this->faker->randomElement($products['mixture_mobility']),
            'frost_resistance' => $this->faker->randomElement($products['frost_resistance']),
            'price' => random_int(1, 9999),
            'comment' => $this->faker->realText(),
        ];
    }
}
