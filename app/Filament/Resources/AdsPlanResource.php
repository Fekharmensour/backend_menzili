<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsPlanResource\Pages;
use App\Models\AdsPlan;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class AdsPlanResource extends Resource
{
    protected static ?string $model = AdsPlan::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.finance');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.ad_plans');
    }

    public static function getModelLabel(): string
    {
        return __('admin.ad_plan');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.ad_plans');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name')
                    ->label(__('admin.name'))
                    ->required()
                    ->maxLength(255),
                FormComponents\TextInput::make('coins')
                    ->label(__('admin.coins'))
                    ->numeric()
                    ->required(),
                FormComponents\TextInput::make('duration_days')
                    ->label(__('admin.duration_days'))
                    ->numeric()
                    ->required(),
                FormComponents\Toggle::make('is_active')
                    ->label(__('admin.active'))
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('coins')
                    ->label(__('admin.coins'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label(__('admin.duration_days'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.active'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label(__('admin.active'))
                    ->options([
                        '1' => __('admin.active'),
                        '0' => __('admin.not_active') ?? 'Inactive',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
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
            'index' => Pages\ListAdsPlans::route('/'),
            'create' => Pages\CreateAdsPlan::route('/create'),
            'edit' => Pages\EditAdsPlan::route('/{record}/edit'),
        ];
    }
}
