<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageCoinResource\Pages;
use App\Models\PackageCoin;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class PackageCoinResource extends Resource
{
    protected static ?string $model = PackageCoin::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-gift';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.finance');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.coin_packages');
    }
    public static function getModelLabel(): string
    {
        return __('admin.coin_package');
    }
    public static function getPluralModelLabel(): string
    {
        return __('admin.coin_packages');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('coins')
                    ->required()->numeric()->minValue(1)->label(__('admin.coins_amount')),
                FormComponents\TextInput::make('price')
                    ->required()->numeric()->minValue(0)->suffix(' ' . __('admin.dzd')),
                FormComponents\DatePicker::make('date_end_offer')
                    ->label(__('admin.offer_end_date'))->nullable(),
                FormComponents\Toggle::make('is_active')->label(__('admin.active'))->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\TextColumn::make('coins')->label(__('admin.coins'))->sortable(),
                Tables\Columns\TextColumn::make('price')->label(__('admin.price'))->numeric()->suffix(' ' . __('admin.dzd'))->sortable(),
                Tables\Columns\TextColumn::make('date_end_offer')->date()->label(__('admin.offer_ends'))->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label(__('admin.active')),
                Tables\Columns\TextColumn::make('coinPurchases_count')
                    ->counts('coinPurchases')
                    ->label(__('admin.sold_count')),
                Tables\Columns\TextColumn::make('created_at')->label(__('admin.created_at'))->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label(__('admin.active')),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('toggle')
                    ->label(fn (PackageCoin $r) => $r->is_active ? __('admin.deactivate') : __('admin.activate'))
                    ->color(fn (PackageCoin $r) => $r->is_active ? 'danger' : 'success')
                    ->icon('heroicon-o-power')
                    ->action(fn (PackageCoin $r) => $r->update(['is_active' => !$r->is_active])),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPackageCoins::route('/'),
            'create' => Pages\CreatePackageCoin::route('/create'),
            'edit'   => Pages\EditPackageCoin::route('/{record}/edit'),
        ];
    }
}
