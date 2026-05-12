<?php

namespace App\Filament\Resources\ListingResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'reports';
    protected static ?string $title = 'Reports';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.user.name')->label('Reporter'),
                Tables\Columns\TextColumn::make('report')->limit(80)->label('Reason'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([])
            ->actions([]);
    }
}
