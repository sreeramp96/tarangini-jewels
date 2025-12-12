<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class StatsOverview extends StatsOverviewWidget
{
    // protected function getStats(): array
    // {
    //     return [
    //         //
    //     ];
    // }
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        return [
            Stat::make('Total Revenue', '₹' . number_format(Order::sum('subtotal'), 0))
                ->description('All-time')
                ->color('success'),

            Stat::make('Total Orders', Order::count())
                ->description('Lifetime')
                ->color('primary'),

            Stat::make('Customers', User::where('is_admin', false)->count())
                ->description('Registered users')
                ->color('info'),

            Stat::make('Low Stock', Product::where('stock', '<=', 5)->count())
                ->description('Needs restock')
                ->color('danger'),
        ];
    }
}
