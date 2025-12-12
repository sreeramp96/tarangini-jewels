<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\Relation;

class RecentOrders extends TableWidget
{
    protected static ?string $heading = 'Recent Orders';

    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder|Relation|null
    {
        // return Order::latest()->limit(5);
        return Order::query()
            ->latest()
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('Order #'),
            Tables\Columns\TextColumn::make('user.name')->label('Customer'),
            Tables\Columns\TextColumn::make('total')->money('INR'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ];
    }
}
