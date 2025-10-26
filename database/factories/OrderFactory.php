<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'order_number' => 'TJ-' . fake()->unique()->numberBetween(100000, 999999),
            'total_amount' => 0, // We will calculate this after creating items
            'status' => fake()->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Create between 1 and 5 order items
            $items = OrderItem::factory()->count(rand(1, 5))->create([
                'order_id' => $order->id,
            ]);

            // Calculate the total_amount from the items and update the order
            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order->total_amount = $total;
            $order->save();
        });
    }
}
