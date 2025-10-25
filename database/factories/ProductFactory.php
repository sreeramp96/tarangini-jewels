<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_IN');

        $baseName = $faker->randomElement(['Elegant', 'Timeless', 'Celestial', 'Royal', 'Radiant'])
            . ' ' . $faker->randomElement(['Gold', 'Diamond', 'Emerald', 'Sapphire'])
            . ' ' . $faker->randomElement(['Necklace', 'Ring', 'Earrings', 'Bangle']);

        $name = $baseName . ' ' . $faker->unique()->randomNumber(5);
        $price = $faker->randomFloat(2, 5000, 150000);

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $faker->paragraph(3),
            'price' => $price,
            'discount_price' => $faker->optional(0.5)->randomFloat(2, $price * 0.7, $price * 0.9),
            'stock' => $faker->numberBetween(0, 50),
            'is_featured' => $faker->boolean(25),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            ProductImage::factory()->create([
                'product_id' => $product->id,
                'image_path' => 'https://picsum.photos/seed/' . $product->id . '1/800/800',
                'is_primary' => true,
            ]);

            ProductImage::factory()->count(rand(2, 3))->create([
                'product_id' => $product->id,
                'image_path' => 'https://picsum.photos/seed/' . $product->id . rand(2, 50) . '/800/800',
                'is_primary' => false,
            ]);
        });
    }
}
