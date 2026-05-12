<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentDurationResource\Pages;
use App\Models\RentDuration;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class RentDurationResource extends Resource
{
    protected static ?string $model = RentDuration::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.config');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.rent_durations');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label('Name (Arabic)')->required(),
                FormComponents\TextInput::make('name_en')->label('Name (English)')->required(),
                FormComponents\TextInput::make('name_fr')->label('Name (French)'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name_ar')->label('Arabic'),
                Tables\Columns\TextColumn::make('name_en')->label('English')->searchable(),
                Tables\Columns\IconColumn::make('active')->boolean(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('active')])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('toggle')
                    ->label(fn (RentDuration $r) => $r->is_active ? 'Deactivate' : 'Activate')
                    ->color(fn (RentDuration $r) => $r->is_active ? 'danger' : 'success')
                    ->icon('heroicon-o-power')
                    ->action(fn (RentDuration $r) => $r->update(['is_active' => !$r->is_active])),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRentDurations::route('/'),
            'create' => Pages\CreateRentDuration::route('/create'),
            'edit'   => Pages\EditRentDuration::route('/{record}/edit'),
        ];
    }
}
