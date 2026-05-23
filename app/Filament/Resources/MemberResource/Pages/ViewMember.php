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
                ->label(__('admin.approve_identity'))
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => $record->identity_status === Member::STATUS_PENDING)
                ->action(function (Member $record) {
                    $record->update([
                        'member_verified_at' => now(),
                        'identity_status' => Member::STATUS_APPROVED,
                        'identity_rejection_reason' => null,
                    ]);
                    \Filament\Notifications\Notification::make()->title(__('admin.identity_approved'))->success()->send();
                }),
            Actions\Action::make('verifyAgent')
                ->label(__('admin.approve_agent'))
                ->icon('heroicon-o-shield-check')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => $record->identity_status === Member::STATUS_APPROVED && $record->agent_status === Member::STATUS_PENDING)
                ->action(function (Member $record) {
                    $record->update([
                        'agent_verified_at' => now(),
                        'agent_status' => Member::STATUS_APPROVED,
                        'agent_rejection_reason' => null,
                    ]);
                    \Filament\Notifications\Notification::make()->title(__('admin.agent_approved'))->success()->send();
                }),
            Actions\Action::make('reject')
                ->label(__('admin.reject'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Member $record) => 
                    ($record->identity_status === Member::STATUS_PENDING) ||
                    ($record->identity_status === Member::STATUS_APPROVED && $record->agent_status === Member::STATUS_PENDING)
                )
                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label(__('admin.description'))
                        ->required(),
                ])
                ->action(function (Member $record, array $data) {
                    if ($record->identity_status !== Member::STATUS_APPROVED) {
                        $record->update([
                            'member_verified_at' => null,
                            'identity_status' => Member::STATUS_REJECTED,
                            'identity_rejection_reason' => $data['reason'],
                        ]);
                    } else {
                        $record->update([
                            'agent_verified_at' => null,
                            'agent_status' => Member::STATUS_REJECTED,
                            'agent_rejection_reason' => $data['reason'],
                        ]);
                    }
                    \Filament\Notifications\Notification::make()->title(__('admin.rejected'))->danger()->send();
                }),
            Actions\Action::make('deactivate')
                ->label(__('admin.deactivate'))
                ->icon('heroicon-o-user-minus')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Member $record) => $record->user && $record->user->is_active)
                ->action(function (Member $record) {
                    $record->user->update(['is_active' => false]);
                    \Filament\Notifications\Notification::make()->title('Member Deactivated')->danger()->send();
                }),
        ];
    }
}
