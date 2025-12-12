<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\LineChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Sales Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(1, Carbon::now()->daysInMonth))->map(function ($day) {
            return Order::whereDay('created_at', $day)->sum('subtotal');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $days->toArray(),
                ],
            ],
            'labels' => range(1, Carbon::now()->daysInMonth),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
