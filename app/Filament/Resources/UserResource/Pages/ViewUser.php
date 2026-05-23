<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('deactivate')
                ->label(__('admin.deactivate'))
                ->icon('heroicon-o-user-minus')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->is_active ?? false)
                ->action(function ($record) {
                    $record->update(['is_active' => false]);
                    \Filament\Notifications\Notification::make()->title('User Deactivated')->danger()->send();
                }),
            Actions\EditAction::make(),
        ];
    }
}
