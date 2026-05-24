<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class CityResource extends Resource
{
    protected static ?string $model = City::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 7;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.config');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.cities');
    }
    public static function getModelLabel(): string
    {
        return __('admin.city');
    }
    public static function getPluralModelLabel(): string
    {
        return __('admin.cities');
    }
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label(__('admin.name') . ' (' . __('admin.arabic') . ')')->required(),
                FormComponents\TextInput::make('name_en')->label(__('admin.name') . ' (' . __('admin.english') . ')')->required(),
                FormComponents\Select::make('wilaya_id')
                    ->relationship('wilaya', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->label(__('admin.wilaya'))
                    ->searchable()
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')->label(__('admin.arabic')),
                Tables\Columns\TextColumn::make('name_en')->label(__('admin.english'))->searchable(),
                Tables\Columns\TextColumn::make('wilaya.name')->label(__('admin.wilaya'))->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('wilaya')
                    ->relationship('wilaya', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->searchable(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit'   => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
