<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\RecentOrders;
use App\Filament\Widgets\LowStockProducts;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';
     protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';

        public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SalesChart::class,
            RecentOrders::class,
            LowStockProducts::class,
        ];
    }

}
