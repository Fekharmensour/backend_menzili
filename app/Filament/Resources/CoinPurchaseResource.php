<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoinPurchaseResource\Pages;
use App\Models\CoinPurchase;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class CoinPurchaseResource extends Resource
{
    protected static ?string $model = CoinPurchase::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string | \UnitEnum | null $navigationGroup = null;
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.finance');
    }
    public static function getNavigationLabel(): string
    {
        return __('admin.coin_purchases');
    }

    public static function getModelLabel(): string
    {
        return __('admin.coin_purchase');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.coin_purchases');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Components\Section::make(__('admin.purchase_details'))->schema([
                InfolistComponents\TextEntry::make('member.user.name')->label(__('admin.member')),
                InfolistComponents\TextEntry::make('member.user.phone')->label(__('admin.phone')),
                InfolistComponents\TextEntry::make('packageCoin.coins')->label(__('admin.coins_amount')),
                InfolistComponents\TextEntry::make('packageCoin.price')->label(__('admin.price_dzd')),
                InfolistComponents\TextEntry::make('payment_method')->label(__('admin.payment_method'))->badge(),
                InfolistComponents\TextEntry::make('status')->label(__('admin.status'))->badge(),
                InfolistComponents\TextEntry::make('reference_code')->label(__('admin.reference_code')),
                InfolistComponents\TextEntry::make('created_at')->label(__('admin.date'))->dateTime(),
            ])->columns(2),
            Components\Section::make(__('admin.receipt_image'))
                ->schema([
                    InfolistComponents\ImageEntry::make('receipt_path')
                        ->label(__('admin.baridimob_receipt'))
                        ->disk('public')
                        ->getStateUsing(fn ($record) => str_replace('/storage/', '', $record->receipt_path))
                        ->height(300)
                        ->visible(fn ($record) => $record && !str_ends_with(strtolower($record->receipt_path), '.pdf')),
                    InfolistComponents\TextEntry::make('receipt_path_pdf')
                        ->label(__('admin.baridimob_receipt'))
                        ->icon('heroicon-o-document-text')
                        ->badge()
                        ->color('primary')
                        ->getStateUsing(fn () => __('admin.view_pdf_receipt'))
                        ->url(fn ($record) => \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('/storage/', '', $record->receipt_path)))
                        ->openUrlInNewTab()
                        ->visible(fn ($record) => $record && str_ends_with(strtolower($record->receipt_path), '.pdf')),
                ])
                ->visible(fn (CoinPurchase $r) => $r->payment_method === 'baridimob'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('receipt_path')
                    ->label(__('admin.receipt'))
                    ->disk('public')
                    ->square()
                    ->getStateUsing(fn ($record) => $record && !str_ends_with(strtolower($record->receipt_path), '.pdf') ? str_replace('/storage/', '', $record->receipt_path) : null)
                    ->visible(fn ($record) => $record && $record->payment_method === 'baridimob' && !str_ends_with(strtolower($record->receipt_path), '.pdf')),
                Tables\Columns\TextColumn::make('receipt_path_pdf')
                    ->label(__('admin.receipt'))
                    ->icon('heroicon-o-document-text')
                    ->badge()
                    ->color('primary')
                    ->getStateUsing(fn () => 'PDF')
                    ->url(fn ($record) => \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('/storage/', '', $record->receipt_path)))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record && $record->payment_method === 'baridimob' && str_ends_with(strtolower($record->receipt_path), '.pdf')),
                Tables\Columns\TextColumn::make('member.user.name')->label(__('admin.member'))->searchable(),
                Tables\Columns\TextColumn::make('packageCoin.coins')->label(__('admin.coins'))->sortable(),
                Tables\Columns\TextColumn::make('packageCoin.price')->label(__('admin.price_dzd'))->numeric(),
                Tables\Columns\BadgeColumn::make('payment_method')
                    ->label(__('admin.payment_method'))
                    ->colors([
                        'primary' => 'chargily',
                        'warning' => 'baridimob',
                        'success' => 'wallet',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('admin.status'))
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger'  => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options(['pending' => __('admin.pending'), 'completed' => __('admin.approved'), 'failed' => __('admin.rejected')]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\Action::make('approve')
                    ->label(__('admin.approve'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (CoinPurchase $r) => $r->status === 'pending')
                    ->action(function (CoinPurchase $record) {
                        $record->update(['status' => 'completed']);
                        $record->member->deposit($record->packageCoin->coins, ['reason' => 'coin_purchase', 'payment_method' => $record->payment_method]);
                        Notification::make()->title(__('admin.purchase_approved'))->success()->send();
                    }),
                Actions\Action::make('reject')
                    ->label(__('admin.reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (CoinPurchase $r) => $r->status === 'pending')
                    ->action(function (CoinPurchase $record) {
                        $record->update(['status' => 'failed']);
                        Notification::make()->title(__('admin.purchase_rejected'))->danger()->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoinPurchases::route('/'),
            'view'  => Pages\ViewCoinPurchase::route('/{record}'),
        ];
    }
}
