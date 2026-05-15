<?php

namespace App\Filament\Resources\ValidationMemberResource\Pages;

use App\Filament\Resources\ValidationMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewValidationMember extends ViewRecord
{
    protected static string $resource = ValidationMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label(__('admin.approve'))
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->visible(fn ($record) => 
                    ($record->identity_status !== \App\Models\Member::STATUS_APPROVED && filled($record->card_id_front_path)) ||
                    ($record->identity_status === \App\Models\Member::STATUS_APPROVED && $record->agent_status !== \App\Models\Member::STATUS_APPROVED && filled($record->document_path))
                )
                ->requiresConfirmation()
                ->action(function ($record) {
                    if ($record->identity_status !== \App\Models\Member::STATUS_APPROVED) {
                        $record->update([
                            'member_verified_at' => now(),
                            'identity_status' => \App\Models\Member::STATUS_APPROVED,
                            'identity_rejection_reason' => null,
                        ]);
                        $title = __('admin.identity_approved');
                    } else {
                        $record->update([
                            'agent_verified_at' => now(),
                            'agent_status' => \App\Models\Member::STATUS_APPROVED,
                            'agent_rejection_reason' => null,
                        ]);
                        $title = __('admin.agent_approved');
                    }
                    \Filament\Notifications\Notification::make()->title($title)->success()->send();
                }),
            Actions\Action::make('reject')
                ->label(__('admin.reject'))
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn ($record) => 
                    ($record->identity_status !== \App\Models\Member::STATUS_APPROVED && filled($record->card_id_front_path)) ||
                    ($record->identity_status === \App\Models\Member::STATUS_APPROVED && $record->agent_status !== \App\Models\Member::STATUS_APPROVED && filled($record->document_path))
                )
                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label(__('admin.description'))
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    if ($record->identity_status !== \App\Models\Member::STATUS_APPROVED) {
                        $record->update([
                            'member_verified_at' => null,
                            'identity_status' => \App\Models\Member::STATUS_REJECTED,
                            'identity_rejection_reason' => $data['reason'],
                        ]);
                    } else {
                        $record->update([
                            'agent_verified_at' => null,
                            'agent_status' => \App\Models\Member::STATUS_REJECTED,
                            'agent_rejection_reason' => $data['reason'],
                        ]);
                    }
                    \Filament\Notifications\Notification::make()->title(__('admin.rejected'))->danger()->send();
                }),
        ];
    }
}
