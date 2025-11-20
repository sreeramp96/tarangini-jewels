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
        $users = User::where('is_admin', false)->get();

        if ($users->isNotEmpty()) {
            foreach ($products as $product) {
                $reviewCount = rand(1, 5);
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
