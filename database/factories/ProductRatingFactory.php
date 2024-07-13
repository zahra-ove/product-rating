<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductRating>
 */
class ProductRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'           => fake()->numberBetween(1, 50),
            'product_attribute_id' => fake()->numberBetween(1, 100),
            'user_id'              => 1,
            'rate'                 => fake()->randomFloat(2, 0, 100)
        ];
    }
}
