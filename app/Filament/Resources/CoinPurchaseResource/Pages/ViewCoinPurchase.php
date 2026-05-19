<?php

namespace App\Filament\Resources\CoinPurchaseResource\Pages;

use App\Filament\Resources\CoinPurchaseResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewCoinPurchase extends ViewRecord
{
    protected static string $resource = CoinPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label(__('admin.approve'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update(['status' => 'completed']);
                    $this->record->member->deposit($this->record->packageCoin->coins, ['reason' => 'coin_purchase', 'payment_method' => $this->record->payment_method]);
                    Notification::make()->title(__('admin.purchase_approved'))->success()->send();
                }),
            Actions\Action::make('reject')
                ->label(__('admin.reject'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update(['status' => 'failed']);
                    Notification::make()->title(__('admin.purchase_rejected'))->danger()->send();
                }),
        ];
    }
}
