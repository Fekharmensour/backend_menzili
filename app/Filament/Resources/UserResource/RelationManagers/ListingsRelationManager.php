<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class ListingsRelationManager extends RelationManager
{
    protected static string $relationship = 'listings';
    protected static ?string $title = 'User Listings';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(40),
                Tables\Columns\TextColumn::make('type.name_en')->label('Type'),
                Tables\Columns\BadgeColumn::make('moderation_status'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->headerActions([])
            ->actions([
                Actions\ViewAction::make(),
            ]);
    }
}
