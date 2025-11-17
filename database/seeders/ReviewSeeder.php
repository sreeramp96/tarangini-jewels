<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        // Get only non-admin users to write reviews
        $users = User::where('is_admin', false)->get();

        if ($users->isNotEmpty()) {
            foreach ($products as $product) {
                // Give each product 1 to 5 random reviews
                $reviewCount = rand(1, 5);

                // Get a random set of users to review this product
                // This ensures one user doesn't review the same product twice
                $reviewers = $users->random(min($reviewCount, $users->count()));

                foreach ($reviewers as $reviewer) {
                    Review::factory()->create([
                        'user_id' => $reviewer->id,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }
}
