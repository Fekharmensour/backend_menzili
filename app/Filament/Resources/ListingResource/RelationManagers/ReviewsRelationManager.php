<?php

namespace App\Filament\Resources\ListingResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';
    protected static ?string $title = 'Reviews';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.user.name')->label('Reviewer'),
                Tables\Columns\TextColumn::make('rating')->sortable(),
                Tables\Columns\TextColumn::make('review')->limit(60),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Actions\DeleteAction::make(),
            ]);
    }
}
