<?php

namespace App\Filament\Resources\AgentConversationResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';
    protected static ?string $title = 'Messages';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user'      => 'info',
                        'assistant' => 'success',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('content')
                    ->label('Message')
                    ->limit(150)
                    ->wrap(),

                Tables\Columns\TextColumn::make('agent')
                    ->label('Agent')
                    ->badge()
                    ->color('primary')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'asc')
            ->headerActions([])
            ->actions([]);
    }
}
