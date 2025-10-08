<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = [
            [
                'name' => 'Festive Gold Discount',
                'type' => 'percentage',
                'value' => 10,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(20),
                'applicable_to' => 'gold-jewelry',
            ],
            [
                'name' => 'Silver Bonanza Offer',
                'type' => 'flat',
                'value' => 500,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(10),
                'applicable_to' => 'silver-jewelry',
            ],
        ];

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}
