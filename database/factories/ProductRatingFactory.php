<?php

namespace Database\Factories;

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
            'product_attribute_id' => ProductAttribute::factory(),
            'user_id' => User::factory(),
            'rate' => fake()->randomFloat(2, 0, 100)
        ];
    }
}
