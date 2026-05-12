<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentConversationResource\Pages;
use App\Filament\Resources\AgentConversationResource\RelationManagers;
use App\Models\AgentConversation;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class AgentConversationResource extends Resource
{
    protected static ?string $model = AgentConversation::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.ai');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.ai_conversations');
    }

    public static function getModelLabel(): string
    {
        return __('admin.ai_conversation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.ai_conversations');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->limit(8)
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('admin.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('admin.phone'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('admin.conversation_title'))
                    ->limit(50)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('messages_count')
                    ->counts('messages')
                    ->label(__('admin.message_count'))
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading(__('admin.no_conversations'))
            ->emptyStateDescription(__('admin.no_conversations_description'))
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.conversation_details'))
                ->schema([
                    InfolistComponents\TextEntry::make('id')->label('ID'),
                    InfolistComponents\TextEntry::make('user.name')->label(__('admin.member')),
                    InfolistComponents\TextEntry::make('user.phone')->label(__('admin.phone')),
                    InfolistComponents\TextEntry::make('title')
                        ->label(__('admin.conversation_title'))
                        ->placeholder('—'),
                    InfolistComponents\TextEntry::make('created_at')
                        ->label(__('admin.date'))
                        ->dateTime(),
                ])->columns(3)->columnSpanFull(),
        ]);
    }

    public static function getRelationManagers(): array
    {
        return [
            RelationManagers\MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgentConversations::route('/'),
            'view'  => Pages\ViewAgentConversation::route('/{record}'),
        ];
    }
}
