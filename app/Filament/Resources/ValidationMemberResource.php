<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidationMemberResource\Pages;
use App\Models\Member;
use Filament\Forms\Components as FormComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ValidationMemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-check-badge';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.validation_members');
    }

    public static function getModelLabel(): string
    {
        return __('admin.validation_member');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.validation_members');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->where(function (Builder $query) {
                $query->where(function ($q) {
                    $q->whereNull('member_verified_at')
                        ->whereNotNull('card_id_front_path');
                })->orWhere(function ($q) {
                    $q->whereNull('agent_verified_at')
                        ->whereNotNull('document_path');
                });
            });
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.user_info'))->schema([
                InfolistComponents\TextEntry::make('user.name')->label(__('admin.name')),
                InfolistComponents\TextEntry::make('user.phone')->label(__('admin.phone')),
                InfolistComponents\TextEntry::make('user.email')->label(__('admin.email')),
            ])->columns(3)->columnSpanFull(),

            Components\Section::make(__('admin.identification_documents'))
                ->schema([
                    InfolistComponents\ImageEntry::make('card_id_front_path')
                        ->label(__('admin.id_card_front'))
                        ->disk('private')
                        ->height(400)
                        ->action(
                            \Filament\Actions\Action::make('view_front')
                                ->modalHeading(__('admin.id_card_front'))
                                ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->card_id_front_path . '" style="width: 100%; height: auto;">'))
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->visible(fn ($record) => filled($record->card_id_front_path)),
                    InfolistComponents\ImageEntry::make('card_id_back_path')
                        ->label(__('admin.id_card_back'))
                        ->disk('private')
                        ->height(400)
                        ->action(
                            \Filament\Actions\Action::make('view_back')
                                ->modalHeading(__('admin.id_card_back'))
                                ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->card_id_back_path . '" style="width: 100%; height: auto;">'))
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->visible(fn ($record) => filled($record->card_id_back_path)),
                ])->columns(2)
                ->columnSpanFull()
                ->visible(fn ($record) => filled($record->card_id_front_path)),

            Components\Section::make(__('admin.professional_document'))
                ->schema([
                    InfolistComponents\TextEntry::make('document_path_pdf')
                        ->label(__('admin.document'))
                        ->state(fn ($record) => $record->document_path)
                        ->formatStateUsing(fn ($state) => new \Illuminate\Support\HtmlString('<iframe src="/secure-documents/' . $state . '" style="width: 100%; height: 800px; border: none; border-radius: 8px;"></iframe>'))
                        ->html()
                        ->columnSpanFull()
                        ->visible(fn ($record) => str_ends_with(strtolower($record->document_path ?? ''), '.pdf')),
                    
                    InfolistComponents\ImageEntry::make('document_path')
                        ->label(__('admin.document'))
                        ->disk('private')
                        ->height(600)
                        ->action(
                            \Filament\Actions\Action::make('view_doc')
                                ->modalHeading(__('admin.document'))
                                ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->document_path . '" style="width: 100%; height: auto;">'))
                                ->modalSubmitAction(false)
                                ->modalCancelAction(false)
                        )
                        ->columnSpanFull()
                        ->visible(fn ($record) => !str_ends_with(strtolower($record->document_path ?? ''), '.pdf') && filled($record->document_path)),
                ])
                ->columnSpanFull()
                ->visible(fn ($record) => filled($record->document_path)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.profile_image')
                    ->label(__('admin.photo'))
                    ->disk('public')
                    ->getStateUsing(fn (Member $record) => str_replace('/storage/', '', $record->user->profile_image))
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')->label(__('admin.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.phone')->label(__('admin.phone'))->searchable(),
                
                Tables\Columns\IconColumn::make('has_identity')
                    ->label(__('admin.identity'))
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->card_id_front_path) && is_null($record->member_verified_at)),
                
                Tables\Columns\IconColumn::make('has_agent')
                    ->label(__('admin.agent'))
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->document_path) && is_null($record->agent_verified_at)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\Action::make('approve_identity')
                    ->label(__('admin.approve_identity'))
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Member $record) => is_null($record->member_verified_at) && filled($record->card_id_front_path))
                    ->requiresConfirmation()
                    ->action(function (Member $record) {
                        $record->update(['member_verified_at' => now()]);
                        Notification::make()
                            ->title(__('admin.identity_approved'))
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('approve_agent')
                    ->label(__('admin.approve_agent'))
                    ->color('primary')
                    ->icon('heroicon-o-briefcase')
                    ->visible(fn (Member $record) => is_null($record->agent_verified_at) && filled($record->document_path))
                    ->requiresConfirmation()
                    ->action(function (Member $record) {
                        $record->update(['agent_verified_at' => now()]);
                        Notification::make()
                            ->title(__('admin.agent_approved'))
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValidationMembers::route('/'),
            'view' => Pages\ViewValidationMember::route('/{record}'),
        ];
    }
}
