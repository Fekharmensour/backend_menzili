<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Filament\Resources\ListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewListing extends ViewRecord
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('ban')
                ->label(__('admin.ban'))
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn ($record) => !($record->is_banned ?? false))
                ->action(function ($record) {
                    $record->update(['is_banned' => true, 'is_active' => false]);
                    \Filament\Notifications\Notification::make()->title('Listing Banned')->danger()->send();
                }),
            Actions\EditAction::make(),
        ];
    }
}
