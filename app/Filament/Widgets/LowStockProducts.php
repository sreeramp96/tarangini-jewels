<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Relation;

class LowStockProducts extends TableWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Low Stock Products';

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder|Relation|null
    {
        return Product::query()
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('stock'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Product')->searchable(),
                Tables\Columns\TextColumn::make('stock')->label('Stock'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
            ])
            ->paginated(false);
    }
}
