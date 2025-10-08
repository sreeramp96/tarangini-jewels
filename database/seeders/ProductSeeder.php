<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Elegant Gold Necklace',
                'slug' => 'elegant-gold-necklace',
                'description' => '24k handcrafted gold necklace with intricate detailing.',
                'price' => 52000,
                'category_id' => 1,
                'image' => 'https://images.unsplash.com/photo-1600181953239-bd0b8c32a3d2?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1600181953239-bd0b8c32a3d2?w=800',
                    'https://images.unsplash.com/photo-1600181953239-bd0b8c32a3d2?w=600',
                    'https://images.unsplash.com/photo-1600181953239-bd0b8c32a3d2?w=400',
                ],
            ],
            [
                'name' => 'Classic Silver Bracelet',
                'slug' => 'classic-silver-bracelet',
                'description' => 'Sterling silver bracelet designed for everyday wear.',
                'price' => 4500,
                'category_id' => 2,
                'image' => 'https://images.unsplash.com/photo-1585241645927-3a32eab3c83c?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1585241645927-3a32eab3c83c?w=800',
                    'https://images.unsplash.com/photo-1585241645927-3a32eab3c83c?w=600',
                ],
            ],
            [
                'name' => 'Diamond Stud Earrings',
                'slug' => 'diamond-stud-earrings',
                'description' => 'Minimalist diamond studs perfect for all occasions.',
                'price' => 75000,
                'category_id' => 3,
                'image' => 'https://images.unsplash.com/photo-1612203576877-bfe2d8a98b43?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1612203576877-bfe2d8a98b43?w=800',
                ],
            ],
            [
                'name' => 'Traditional Temple Necklace',
                'slug' => 'traditional-temple-necklace',
                'description' => 'Antique finish temple jewelry inspired by South Indian art.',
                'price' => 64000,
                'category_id' => 4,
                'image' => 'https://images.unsplash.com/photo-1629180161460-8f263cba3d2f?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1629180161460-8f263cba3d2f?w=800',
                ],
            ],
            [
                'name' => 'Bridal Diamond Choker',
                'slug' => 'bridal-diamond-choker',
                'description' => 'Exclusive bridal choker set with gold and diamond fusion.',
                'price' => 125000,
                'category_id' => 5,
                'image' => 'https://images.unsplash.com/photo-1587057444771-15e48ee7f1c4?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1587057444771-15e48ee7f1c4?w=800',
                    'https://images.unsplash.com/photo-1587057444771-15e48ee7f1c4?w=600',
                ],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
