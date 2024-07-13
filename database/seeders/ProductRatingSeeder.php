<?php

namespace Database\Seeders;

use App\Models\ProductRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductRating::factory()->count(500)->create();
    }
}
