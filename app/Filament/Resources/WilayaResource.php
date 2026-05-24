<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WilayaResource\Pages;
use App\Models\Wilaya;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class WilayaResource extends Resource
{
    protected static ?string $model = Wilaya::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.config');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.wilayas');
    }
    public static function getModelLabel(): string
    {
        return __('admin.wilaya');
    }
    public static function getPluralModelLabel(): string
    {
        return __('admin.wilayas');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label(__('admin.name') . ' (' . __('admin.arabic') . ')')->required(),
                FormComponents\TextInput::make('name_en')->label(__('admin.name') . ' (' . __('admin.english') . ')')->required(),
                FormComponents\TextInput::make('code')->required()->numeric(),
                FormComponents\Select::make('country_id')
                    ->relationship('country', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->sortable(),
                Tables\Columns\TextColumn::make('name_ar')->label(__('admin.arabic')),
                Tables\Columns\TextColumn::make('name_en')->label(__('admin.english'))->searchable(),
                Tables\Columns\TextColumn::make('country.name')->label(__('admin.country')),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWilayas::route('/'),
            'create' => Pages\CreateWilaya::route('/create'),
            'edit'   => Pages\EditWilaya::route('/{record}/edit'),
        ];
    }
}
