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
            Components\Section::make(__('admin.member_info'))->schema([
                InfolistComponents\TextEntry::make('first_name')->label(__('admin.first_name')),
                InfolistComponents\TextEntry::make('last_name')->label(__('admin.last_name')),
                InfolistComponents\TextEntry::make('type')
                    ->label(__('admin.type'))
                    ->badge()
                    ->color(fn ($state) => $state === 'agent' ? 'primary' : 'success'),
            ])->columns(3)->columnSpanFull(),
            Components\Section::make(__('admin.verification_status'))->schema([
                InfolistComponents\TextEntry::make('member_verified_at')
                    ->label(__('admin.identity_status'))
                    ->placeholder(__('admin.unverified'))
                    ->dateTime()
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                InfolistComponents\TextEntry::make('agent_verified_at')
                    ->label(__('admin.agent_status'))
                    ->placeholder(__('admin.regular_member'))
                    ->dateTime()
                    ->badge()
                    ->color(fn ($state) => $state ? 'primary' : 'gray'),
            ])->columns(2)->columnSpanFull(),
            Components\Section::make(__('admin.identification_documents'))->schema([
                InfolistComponents\ImageEntry::make('card_id_front_path')
                    ->label(__('admin.id_card_front'))
                    ->disk('private')
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_front')
                            ->modalHeading(__('admin.id_card_front'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->card_id_front_path . '" style="width: 100%; height: auto;">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    )
                    ->columnSpan(1),
                InfolistComponents\ImageEntry::make('card_id_back_path')
                    ->label(__('admin.id_card_back'))
                    ->disk('private')
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_back')
                            ->modalHeading(__('admin.id_card_back'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->card_id_back_path . '" style="width: 100%; height: auto;">'))
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    )
                    ->columnSpan(1),
                InfolistComponents\TextEntry::make('document_path_pdf')
                    ->label(__('admin.professional_document'))
                    ->state(fn ($record) => $record->document_path)
                    ->formatStateUsing(fn ($state) => new \Illuminate\Support\HtmlString('<iframe src="/secure-documents/' . $state . '" style="width: 100%; height: 500px; border: none; border-radius: 8px;"></iframe>'))
                    ->html()
                    ->columnSpanFull()
                    ->visible(fn ($record) => str_ends_with(strtolower($record->document_path ?? ''), '.pdf')),
                    
                InfolistComponents\ImageEntry::make('document_path')
                    ->label(__('admin.professional_document'))
                    ->disk('private')
                    ->height(250)
                    ->action(
                        \Filament\Actions\Action::make('view_doc')
                            ->modalHeading(__('admin.professional_document'))
                            ->modalContent(fn ($record) => new \Illuminate\Support\HtmlString('<img src="/secure-documents/' . $record->document_path . '" style="width: 100%; height: auto;">'))
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
                Tables\Columns\ImageColumn::make('user.profile_image')
                    ->label(__('admin.photo'))
                    ->disk('public')
                    ->getStateUsing(fn (Member $record) => str_replace('/storage/', '', $record->user->profile_image))
                    ->circular(),
                Tables\Columns\TextColumn::make('user.name')->label(__('admin.name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.phone')->label(__('admin.phone'))->searchable(),
                Tables\Columns\BadgeColumn::make('identity_status')
                    ->label(__('admin.identity'))
                    ->getStateUsing(function (Member $record) {
                        if ($record->member_verified_at) return __('admin.verified');
                        if ($record->card_id_front_path) return __('admin.pending');
                        return __('admin.missing_docs');
                    })
                    ->colors([
                        'success' => __('admin.verified'),
                        'warning' => __('admin.pending'),
                        'gray'    => __('admin.missing_docs'),
                    ]),
                Tables\Columns\BadgeColumn::make('agent_status')
                    ->label(__('admin.agent'))
                    ->getStateUsing(function (Member $record) {
                        if ($record->agent_verified_at) return __('admin.verified_agent');
                        if ($record->document_path) return __('admin.pending_review');
                        return __('admin.regular');
                    })
                    ->colors([
                        'primary' => __('admin.verified_agent'),
                        'warning' => __('admin.pending_review'),
                        'gray'    => __('admin.regular'),
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
