<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoostResource\Pages;
use App\Models\Boost;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class BoostResource extends Resource
{
    protected static ?string $model = Boost::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rocket-launch';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.finance');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.boosts');
    }

    public static function getModelLabel(): string
    {
        return __('admin.boost');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.boosts');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('listing.title')->label(__('admin.listing'))->limit(30)->searchable(),
                Tables\Columns\TextColumn::make('member.user.name')->label(__('admin.member'))->searchable(),
                Tables\Columns\TextColumn::make('coins_spent')->label(__('admin.coins_spent'))->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('admin.status'))
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger'  => 'rejected',
                        'gray'    => 'expired',
                    ]),
                Tables\Columns\TextColumn::make('started_at')->label(__('admin.started_at'))->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('expires_at')->label(__('admin.expires_at'))->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options(['active' => __('admin.active'), 'expired' => __('admin.expired'), 'pending' => __('admin.pending'), 'rejected' => __('admin.rejected')]),
            ])
            ->actions([
                Actions\Action::make('viewListing')
                    ->label(__('admin.view_listing'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (Boost $record) => $record->listing_id ? ListingResource::getUrl('view', ['record' => $record->listing_id]) : null),
                Actions\Action::make('forceExpire')
                    ->label(__('admin.force_expire'))
                    ->icon('heroicon-o-clock')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Boost $r) => $r->status === 'active')
                    ->action(function (Boost $record) {
                        $record->expire();
                        if ($record->listing && $record->listing->active_boost_id === $record->id) {
                            $record->listing->update(['active_boost_id' => null, 'boost_level' => 0]);
                        }
                        Notification::make()->title('Boost force-expired')->warning()->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoosts::route('/'),
        ];
    }
}
