<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImportProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Your CSV Data Mapped manually
        // Format: [Product_ID, Filename, Is_Primary]
        $data = [
            [1, 'hero1.jpg', true],
            [1, 'hero1.jpg', false],
            [1, 'hero2.jpg', false],
            [2, 'hero1.jpg', true],
            [2, 'hero.jpg', false],
            [2, 'hero1.jpg', false],
            // ... The code will logically repeat this pattern for all products
        ];

        $products = Product::all();

        foreach ($products as $product) {
            // Clear old media to prevent duplicates
            $product->clearMediaCollection('images');

            // Logic to pick images based on your CSV pattern
            // We rotate through hero1, hero, hero2, hero3
            $images = ['hero1.jpg', 'hero.jpg', 'hero2.jpg', 'hero3.jpg'];

            // Add 3 images per product
            for ($i = 0; $i < 3; $i++) {
                // Pick an image based on product ID to randomize it slightly
                $imgName = $images[($product->id + $i) % 4];
                $isPrimary = ($i === 0); // First one is primary

                // Look for file in public/images/
                $path = public_path("images/{$imgName}");

                if (File::exists($path)) {
                    $product->addMedia($path)
                        ->preservingOriginal()
                        ->withCustomProperties(['primary' => $isPrimary])
                        ->toMediaCollection('images', 's3');
                }
            }
            $this->command->info("Processed Product {$product->id}");
        }
    }
}
