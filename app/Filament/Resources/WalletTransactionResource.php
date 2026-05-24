<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletTransactionResource\Pages;
use Bavix\Wallet\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WalletTransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.wallet_transactions');
    }

    public static function getModelLabel(): string
    {
        return __('admin.transaction');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.wallet_transactions');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('admin.id'))->sortable(),
                Tables\Columns\TextColumn::make('payable_type')
                    ->label(__('admin.type'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_replace('App\\Models\\', '', $state)),
                Tables\Columns\TextColumn::make('payable.user.name')
                    ->label(__('admin.member'))
                    ->placeholder('System / N/A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('admin.type'))
                    ->formatStateUsing(fn ($state) => __("transactions.{$state}"))
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => $state === __('transactions.deposit'),
                        'danger' => fn ($state) => $state === __('transactions.withdraw'),
                    ]),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('admin.price'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('meta.reason')
                    ->label(__('admin.reason'))
                    ->formatStateUsing(fn ($state, $record) => 
                        (__("transactions.{$state}") !== "transactions.{$state}" ? __("transactions.{$state}") : ucfirst(str_replace('_', ' ', $state))) . 
                        (($record->meta['plan_name'] ?? $record->meta['payment_method'] ?? null) ? " (" . ($record->meta['plan_name'] ?? $record->meta['payment_method'] ?? "") . ")" : "")
                    )
                    ->description(fn ($record) => $record->meta['ad_title'] ?? $record->meta['description'] ?? null)
                    ->placeholder('N/A'),
                Tables\Columns\IconColumn::make('confirmed')
                    ->label(__('admin.verified'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'deposit' => __('admin.deposit'),
                        'withdraw' => __('admin.withdraw'),
                    ]),
                Tables\Filters\TernaryFilter::make('confirmed')
                    ->label(__('admin.confirmed')),
            ])
            ->actions([
                // Read only
            ])
            ->bulkActions([
                // Read only
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWalletTransactions::route('/'),
        ];
    }
}
