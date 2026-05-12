<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMember extends ViewRecord
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('verifyMember')
                ->label('Verify Identity')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => is_null($record->member_verified_at))
                ->action(function (Member $record) {
                    $record->update(['member_verified_at' => now()]);
                    \Filament\Notifications\Notification::make()->title('Member verified')->success()->send();
                }),
            Actions\Action::make('verifyAgent')
                ->label('Verify Agent')
                ->icon('heroicon-o-shield-check')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => is_null($record->agent_verified_at))
                ->action(function (Member $record) {
                    $record->update(['agent_verified_at' => now()]);
                    \Filament\Notifications\Notification::make()->title('Agent verified')->success()->send();
                }),
            Actions\Action::make('revoke')
                ->label('Revoke Verifications')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => !is_null($record->member_verified_at) || !is_null($record->agent_verified_at))
                ->action(function (Member $record) {
                    $record->update(['member_verified_at' => null, 'agent_verified_at' => null]);
                    \Filament\Notifications\Notification::make()->title('Verifications revoked')->warning()->send();
                }),
        ];
    }
}
