<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random product
        $product = Product::inRandomOrder()->first();

        return [
            // 'order_id' will be set by the OrderFactory
            'product_id' => $product->id,
            'quantity' => fake()->numberBetween(1, 3),
            // Use the product's actual price (or discount price if it exists)
            'price' => $product->discount_price ?? $product->price,
        ];
    }
}
