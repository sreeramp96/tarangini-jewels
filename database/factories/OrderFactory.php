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
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'order_number' => 'TJ-' . fake()->unique()->numberBetween(100000, 999999),
            'status' => fake()->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),

            // --- ADD DUMMY/FAKE DATA FOR ALL NEW FIELDS ---
            'subtotal' => 0, // We will calculate this in the 'configure' method
            'taxes' => 0, // Will be calculated
            'shipping_cost' => 100.00, // Or fake()->randomFloat(2, 50, 200)
            'total_amount' => 0, // Will be calculated

            'shipping_first_name' => $firstName,
            'shipping_last_name' => $lastName,
            'shipping_phone' => fake()->phoneNumber(),
            'shipping_address' => fake()->streetAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->state(),
            'shipping_zipcode' => fake()->postcode(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Create between 1 and 5 order items for this order
            $items = OrderItem::factory()->count(rand(1, 5))->create([
                'order_id' => $order->id,
            ]);

            // --- RE-CALCULATE AND UPDATE TOTALS ---
            $subtotal = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $taxRate = 0.18; // 18%
            $taxes = $subtotal * $taxRate;
            $shippingCost = 100.00; // Use the same value from definition()
            $grandTotal = $subtotal + $taxes + $shippingCost;

            // Update the order with the correct calculated values
            $order->update([
                'subtotal' => $subtotal,
                'taxes' => $taxes,
                'shipping_cost' => $shippingCost,
                'total_amount' => $grandTotal,
            ]);
        });
    }
}
