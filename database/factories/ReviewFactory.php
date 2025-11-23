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
        $faker = \Faker\Factory::create('en_IN');
        return [
            // We will set user_id and product_id in the seeder
            'rating' => $faker->numberBetween(3, 5), // Make reviews mostly good
            'comment' => $faker->paragraph(rand(1, 3)), // 1 to 3 sentences
        ];
    }
}
