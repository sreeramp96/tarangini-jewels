<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all product IDs to ensure referential integrity
        $productIds = Product::pluck('id');

        if ($productIds->isEmpty()) {
            $this->command->info('No products found. Run ProductSeeder first.');
            return;
        }

        $imagesToInsert = [];
        $basePath = 'storage/images/products/';

        foreach ($productIds as $productId) {
            // First image is marked as primary/main image
            $imagesToInsert[] = [
                'product_id' => $productId,
                'image_path' => $basePath . $productId . '_main.jpg',
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add 2-3 additional gallery images
            for ($i = 1; $i <= 3; $i++) {
                $imagesToInsert[] = [
                    'product_id' => $productId,
                    'image_path' => $basePath . $productId . '_gallery_' . $i . '.jpg',
                    'is_primary' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all images in a single batch for performance
        Image::insert($imagesToInsert);
    }
}
