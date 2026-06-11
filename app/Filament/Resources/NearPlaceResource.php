<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NearPlaceResource\Pages;
use App\Models\NearPlace;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class NearPlaceResource extends Resource
{
    protected static ?string $model = NearPlace::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';
    protected static string|\UnitEnum|null $navigationGroup = null;
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.config');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.near_places');
    }
    public static function getModelLabel(): string
    {
        return __('admin.near_place');
    }
    public static function getPluralModelLabel(): string
    {
        return __('admin.near_places');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label(__('admin.name') . ' (' . __('admin.arabic') . ')')->required(),
                FormComponents\TextInput::make('name_en')->label(__('admin.name') . ' (' . __('admin.english') . ')')->required(),
                FormComponents\TextInput::make('name_fr')->label(__('admin.name') . ' (' . __('admin.french') . ')'),
                FormComponents\FileUpload::make('icon_path')
                    ->label(__('admin.icon_image'))
                    ->image()
                    ->disk('public')
                    ->directory('near_places')
                    ->saveUploadedFileUsing(function ($file) {
                        return app(\App\Services\Image\ImageService::class)->storeAsWebp($file, 'near_places');
                    })
                    ->columnSpanFull(),
                FormComponents\TextInput::make('icon')->label(__('admin.icon_class')),
                FormComponents\Textarea::make('description')->rows(2)->columnSpanFull(),
                FormComponents\Toggle::make('active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\ImageColumn::make('icon_path')
                    ->label(__('admin.icon'))
                    ->disk('public')
                    ->getStateUsing(fn($record) => str_replace('/storage/', '', $record->icon_path))
                    ->circular(),
                Tables\Columns\TextColumn::make('name_ar')->label(__('admin.arabic')),
                Tables\Columns\TextColumn::make('name_en')->label(__('admin.english'))->searchable(),
                Tables\Columns\IconColumn::make('active')->label(__('admin.active'))->boolean(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('active')])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('toggle')
                    ->label(fn(NearPlace $r) => $r->is_active ? __('admin.deactivate') : __('admin.activate'))
                    ->color(fn(NearPlace $r) => $r->is_active ? 'danger' : 'success')
                    ->icon('heroicon-o-power')
                    ->action(fn(NearPlace $r) => $r->update(['is_active' => !$r->is_active])),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNearPlaces::route('/'),
            'create' => Pages\CreateNearPlace::route('/create'),
            'edit' => Pages\EditNearPlace::route('/{record}/edit'),
        ];
    }
}
