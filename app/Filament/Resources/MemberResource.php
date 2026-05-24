<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
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

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-identification';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.members');
    }

    public static function getModelLabel(): string
    {
        return __('admin.member');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.members');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.member_info'))->schema([
                FormComponents\TextInput::make('user.name')->label(__('admin.name'))->disabled(),
                FormComponents\TextInput::make('user.phone')->label(__('admin.phone'))->disabled(),
                FormComponents\TextInput::make('balance')->label(__('admin.wallet_balance'))->numeric()->disabled(),
            ])->columns(3),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.user_info'))->schema([
                InfolistComponents\TextEntry::make('user.name')->label(__('admin.name')),
                InfolistComponents\TextEntry::make('user.phone')->label(__('admin.phone')),
            ])->columns(2)->columnSpanFull(),
            Components\Section::make(__('admin.verification_status'))->schema([
                InfolistComponents\TextEntry::make('identity_status')
                    ->label(__('admin.identity_status'))
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => __("admin.{$state}")),
                InfolistComponents\TextEntry::make('agent_status')
                    ->label(__('admin.agent_status'))
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'primary',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => __("admin.{$state}")),
            ])->columns(2)->columnSpanFull(),
            Components\Section::make(__('admin.identification_documents'))->schema([
                InfolistComponents\ImageEntry::make('card_id_front_path')
                    ->label(__('admin.id_card_front'))
                    ->state(fn ($record) => $record && $record->card_id_front_path ? route('private.storage', ['path' => $record->card_id_front_path]) : null)
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_front')
                            ->modalHeading(__('admin.id_card_front'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->card_id_front_path]) . '" style="width: 100%; height: auto;">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    )
                    ->columnSpan(1),
                InfolistComponents\ImageEntry::make('card_id_back_path')
                    ->label(__('admin.id_card_back'))
                    ->state(fn ($record) => $record && $record->card_id_back_path ? route('private.storage', ['path' => $record->card_id_back_path]) : null)
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_back')
                            ->modalHeading(__('admin.id_card_back'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->card_id_back_path]) . '" style="width: 100%; height: auto;">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    )
                    ->columnSpan(1),
                InfolistComponents\TextEntry::make('document_path_pdf')
                    ->label(__('admin.professional_document'))
                    ->state(fn ($record) => $record->document_path)
                    ->formatStateUsing(fn ($state) => new \Illuminate\Support\HtmlString('<iframe src="' . route('private.storage', ['path' => $state]) . '" style="width: 100%; height: 500px; border: none; border-radius: 8px;"></iframe>'))
                    ->html()
                    ->columnSpanFull()
                    ->visible(fn ($record) => str_ends_with(strtolower($record->document_path ?? ''), '.pdf')),
                    
                InfolistComponents\ImageEntry::make('document_path')
                    ->label(__('admin.professional_document'))
                    ->state(fn ($record) => $record && !str_ends_with(strtolower($record->document_path ?? ''), '.pdf') && filled($record->document_path) ? route('private.storage', ['path' => $record->document_path]) : null)
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_doc')
                            ->modalHeading(__('admin.professional_document'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="' . route('private.storage', ['path' => $record->document_path]) . '" style="width: 100%; height: auto;">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    )
                    ->columnSpanFull()
                    ->visible(fn ($record) => !str_ends_with(strtolower($record->document_path ?? ''), '.pdf') && filled($record->document_path)),
            ])->columns(3)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\ImageColumn::make('user.profile_image')
                    ->label(__('admin.photo'))
                    ->disk('public')
                    ->getStateUsing(fn (Member $record) => $record->user->profile_image ? str_replace('/storage/', '', $record->user->profile_image) : null)
                    ->defaultImageUrl(fn (Member $record) => "https://ui-avatars.com/api/?name=" . urlencode($record->user->name) . "&background=0078fd&color=fff&bold=true")
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')->label(__('admin.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.phone')->label(__('admin.phone'))->searchable(),
                Tables\Columns\BadgeColumn::make('identity_status')
                    ->label(__('admin.identity'))
                    ->formatStateUsing(fn (string $state): string => __("admin.{$state}"))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'unsubmitted',
                    ]),
                Tables\Columns\BadgeColumn::make('agent_status')
                    ->label(__('admin.agent'))
                    ->formatStateUsing(fn (string $state): string => __("admin.{$state}"))
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'unsubmitted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('pending_identity')
                    ->query(fn ($query) => $query->whereNull('member_verified_at')->whereNotNull('card_id_front_path')),
                Tables\Filters\Filter::make('pending_agent')
                    ->query(fn ($query) => $query->whereNull('agent_verified_at')->whereNotNull('document_path')),
            ])
            ->actions([
                Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'view'  => Pages\ViewMember::route('/{record}'),
        ];
    }
}
