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
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label('Name (Arabic)')->required(),
                FormComponents\TextInput::make('name_en')->label('Name (English)')->required(),
                FormComponents\Select::make('wilaya_id')
                    ->relationship('wilaya', 'name_en')
                    ->searchable()
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')->label('Arabic'),
                Tables\Columns\TextColumn::make('name_en')->label('English')->searchable(),
                Tables\Columns\TextColumn::make('wilaya.name_en')->label('Wilaya')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('wilaya')
                    ->relationship('wilaya', 'name_en')
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
