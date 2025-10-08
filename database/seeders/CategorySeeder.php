<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Gold Jewelry', 'slug' => 'gold-jewelry'],
            ['name' => 'Silver Jewelry', 'slug' => 'silver-jewelry'],
            ['name' => 'Diamond Jewelry', 'slug' => 'diamond-jewelry'],
            ['name' => 'Temple Jewelry', 'slug' => 'temple-jewelry'],
            ['name' => 'Bridal Collection', 'slug' => 'bridal-collection'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
