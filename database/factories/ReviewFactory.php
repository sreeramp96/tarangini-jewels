<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
return [
            // We will set user_id and product_id in the seeder
            'rating' => fake()->numberBetween(3, 5), // Make reviews mostly good
            'comment' => fake()->paragraph(rand(1, 3)), // 1 to 3 sentences
        ];
    }
}
