<?php

namespace App\Filament\Resources\Orders;
use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\OrderResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingCart;

    public static function form(Schema $schema): Schema
    {
        // return OrderForm::configure($schema);
         return $schema->schema([
            Section::make('Order Details')->schema([
                TextInput::make('order_number')->disabled(),

                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),

                Select::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),

                TextInput::make('total_amount')->disabled(),
            ]),

            Section::make('Shipping')->schema([
                TextInput::make('shipping_first_name'),
                TextInput::make('shipping_last_name'),
                TextInput::make('shipping_phone'),
                TextInput::make('shipping_address')->columnSpanFull(),
                TextInput::make('shipping_city'),
                TextInput::make('shipping_state'),
                TextInput::make('shipping_zipcode'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        // return OrdersTable::configure($table);
        return $table
            ->columns([
                TextColumn::make('order_number')->sortable(),
                TextColumn::make('user.name')->label('Customer'),
                TextColumn::make('total_amount')->money('INR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->date(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
