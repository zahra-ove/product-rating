<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductRating;
use App\Models\User;
use Tests\TestCase;


class ProductRatingTest extends TestCase
{

    /** @test */
    public function it_can_list_all_ratings_for_a_specific_product()
    {
        // Create a product, product attributes, users, and product ratings
        $product = Product::factory()->create();
        $productAttributes = ProductAttribute::factory()->count(3)->create(['product_id' => $product->id]);
        $users = User::factory()->count(2)->create();

        foreach ($productAttributes as $productAttribute) {
            ProductRating::factory()->create([
                'product_id' => $product->id,
                'product_attribute_id' => $productAttribute->id,
                'user_id' => $users->random()->id,
                'rate' => rand(0, 100)
            ]);
        }

        // Make a GET request to the product-ratings.index route
        $response = $this->getJson(route('products-rating.index', $product->id));

        // Assert that the response status is 200 OK
        $response->assertStatus(200);

        // Assert the JSON structure of the response
        $response->assertJsonStructure([
            'product' => [
                'name',
                'price'
            ],
            'data' => [
                '*' => [
                    'user' => [
                        'id',
                        'name',
                        'email'
                    ],
                    'attribute' => [
                        'id',
                        'name'
                    ],
                    'rate'
                ]
            ]
        ]);
    }


    /** @test */
    public function it_can_store_a_new_product_rating()
    {
        $product = Product::factory()->create();
        $productAttribute = ProductAttribute::factory()->create(['product_id' => $product->id]);
        $user = User::factory()->create();

        $response = $this->postJson(route('products-rating.store'), [
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'rate' => 95.5,
            'user_id' => $user->id
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email'
                    ],
                    'attribute' => [
                        'id',
                        'name'
                    ],
                    'rate'
                ]
            ])
            ->assertJson([
                'message' => 'success'
            ]);
    }

    /** @test */
    public function it_can_show_ratings_for_a_specific_product_attribute()
    {
        $product = Product::factory()->create();
        $productAttribute = ProductAttribute::factory()->create(['product_id' => $product->id]);
        ProductRating::factory()->create([
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'rate' => 70
        ]);

        ProductRating::factory()->create([
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'rate' => 30
        ]);

        $response = $this->getJson(route('products-rating.show',
                                    ['product_id' => $product->id,
                                     'product_attribute_id' => $productAttribute->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'product' => [
                    'name',
                    'price'
                ],
                'data'
            ])
            ->assertJson([
                'product' => [
                    'name'  => $product->name,
                    'price' => $product->price
                ],
                'data' => [70, 30]
            ]);
    }

    /** @test */
    public function it_can_update_a_product_rating()
    {
        $product = Product::factory()->create();
        $productAttribute = ProductAttribute::factory()->create(['product_id' => $product->id]);
        $user = User::factory()->create();
        $productRating = ProductRating::factory()->create([
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'user_id' => $user->id,
            'rate' => 50
        ]);

        $response = $this->patchJson(route('products-rating.update'), [
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'rate' => 75.5,
            'user_id' => $user->id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'success'
            ]);

        $this->assertDatabaseHas('product_ratings', [
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'user_id' => $user->id,
            'rate' => 75.5
        ]);
    }

    /** @test */
    public function it_can_delete_a_product_rating()
    {

        $product = Product::factory()->create();
        $productAttribute = ProductAttribute::factory()->create(['product_id' => $product->id]);
        $user = User::factory()->create();
        $productRating = ProductRating::factory()->create([
            'product_id' => $product->id,
            'product_attribute_id' => $productAttribute->id,
            'user_id' => $user->id,
            'rate' => 50
        ]);

        $response = $this->deleteJson(route('products-rating.destroy', $productRating->id));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('product_ratings', [
            'id' => $productRating->id
        ]);
    }

}
