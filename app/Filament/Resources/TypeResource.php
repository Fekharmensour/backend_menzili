<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeResource\Pages;
use App\Models\Type;
use Filament\Forms\Components as FormComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class TypeResource extends Resource
{
    protected static ?string $model = Type::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.config');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.property_types');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make()->schema([
                FormComponents\TextInput::make('name_ar')->label('Name (Arabic)')->required(),
                FormComponents\TextInput::make('name_en')->label('Name (English)')->required(),
                FormComponents\TextInput::make('name_fr')->label('Name (French)'),
                FormComponents\FileUpload::make('icon_path')
                    ->label('Icon Image')
                    ->image()
                    ->disk('public')
                    ->directory('types')
                    ->columnSpanFull(),
                FormComponents\TextInput::make('icon')->label('Icon Class'),
                FormComponents\Textarea::make('description')->rows(2)->columnSpanFull(),
                FormComponents\Toggle::make('active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon_path')
                    ->label('Icon')
                    ->disk('public')
                    ->getStateUsing(fn ($record) => str_replace('/storage/', '', $record->icon_path))
                    ->circular(),
                Tables\Columns\TextColumn::make('name_ar')->label('Arabic'),
                Tables\Columns\TextColumn::make('name_en')->label('English')->searchable(),
                Tables\Columns\IconColumn::make('active')->boolean(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('active')])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('toggle')
                    ->label(fn (Type $r) => $r->is_active ? 'Deactivate' : 'Activate')
                    ->color(fn (Type $r) => $r->is_active ? 'danger' : 'success')
                    ->icon('heroicon-o-power')
                    ->action(fn (Type $r) => $r->update(['is_active' => !$r->is_active])),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTypes::route('/'),
            'create' => Pages\CreateType::route('/create'),
            'edit'   => Pages\EditType::route('/{record}/edit'),
        ];
    }
}
