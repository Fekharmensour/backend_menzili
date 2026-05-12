<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class CoinPurchasesRelationManager extends RelationManager
{
    protected static string $relationship = 'coinPurchases';
    protected static ?string $title = 'Coin Purchase History';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('packageCoin.coins')->label('Coins'),
                Tables\Columns\TextColumn::make('packageCoin.price')->label('Paid (DZD)'),
                Tables\Columns\BadgeColumn::make('payment_method'),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->headerActions([])
            ->actions([
                Actions\ViewAction::make(),
            ]);
    }
}
