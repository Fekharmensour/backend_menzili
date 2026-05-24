<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components as FormComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.users');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.users');
    }

    public static function getModelLabel(): string
    {
        return __('admin.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.users');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.personal_info'))->schema([
                FormComponents\TextInput::make('name')
                    ->label(__('admin.name'))
                    ->maxLength(255),
                FormComponents\TextInput::make('phone')
                    ->label(__('admin.phone'))
                    ->required()->unique(ignoreRecord: true),
                FormComponents\TextInput::make('email')
                    ->label(__('admin.email'))
                    ->email()->unique(ignoreRecord: true),
            ])->columns(3),
            Components\Section::make(__('admin.status'))->schema([
                FormComponents\Toggle::make('is_active')->label(__('admin.active')),
                FormComponents\Toggle::make('is_admin')->label(__('admin.admin_access')),
                FormComponents\TextInput::make('password')
                    ->label(__('admin.new_password'))
                    ->password()
                    ->dehydrated(fn ($state) => filled($state)),
            ])->columns(3),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.user_details'))->schema([
                InfolistComponents\TextEntry::make('name')->label(__('admin.name')),
                InfolistComponents\TextEntry::make('phone')->label(__('admin.phone')),
                InfolistComponents\TextEntry::make('email')->label(__('admin.email')),
                InfolistComponents\TextEntry::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime(),
                InfolistComponents\TextEntry::make('last_login_at')
                    ->label(__('admin.last_login_at'))
                    ->dateTime(),
            ])->columns(3),
            Components\Section::make(__('admin.member_profile'))
                ->schema([
                    InfolistComponents\TextEntry::make('member.member_verified_at')
                        ->label(__('admin.verified_at'))
                        ->dateTime()
                        ->placeholder(__('admin.not_verified')),
                    InfolistComponents\TextEntry::make('member.agent_verified_at')
                        ->label(__('admin.agent_verified_at'))
                        ->dateTime()
                        ->placeholder(__('admin.not_an_agent')),
                    InfolistComponents\TextEntry::make('member.balance')
                        ->label(__('admin.wallet_balance'))
                        ->numeric()
                        ->suffix(' ' . __('admin.coins')),
                ])
                ->columns(3)
                ->visible(fn (User $record) => !is_null($record->member)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\ImageColumn::make('profile_image')
                    ->label(__('admin.photo'))
                    ->disk('public')
                    ->defaultImageUrl(fn (User $record) => "https://ui-avatars.com/api/?name=" . urlencode($record->name) . "&background=0078fd&color=fff&bold=true")
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('admin.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.email'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.active'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->label(__('admin.admin'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label(__('admin.active')),
                Tables\Filters\TernaryFilter::make('is_admin')->label(__('admin.admin')),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('toggleActive')
                    ->label(fn (User $record) => $record->is_active ? __('admin.deactivate') : __('admin.activate'))
                    ->icon(fn (User $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (User $record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(fn (User $record) => $record->update(['is_active' => !$record->is_active])),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelationManagers(): array
    {
        return [
            RelationManagers\ListingsRelationManager::class,
            RelationManagers\CoinPurchasesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
