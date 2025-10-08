<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Anjali Menon',
                'message' => 'Absolutely loved the gold necklace I purchased! Exquisite craftsmanship.',
            ],
            [
                'name' => 'Ravi Nair',
                'message' => 'Fantastic designs and quick delivery. Highly recommended!',
            ],
            [
                'name' => 'Priya Varma',
                'message' => 'The silver bracelet I ordered looks even better in real life!',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
