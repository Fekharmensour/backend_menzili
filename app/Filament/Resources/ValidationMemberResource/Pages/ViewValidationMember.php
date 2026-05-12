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
            Actions\Action::make('approve_identity')
                ->label(__('admin.approve_identity'))
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->visible(fn ($record) => is_null($record->member_verified_at) && filled($record->card_id_front_path))
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['member_verified_at' => now()]);
                    $this->notify('success', __('admin.identity_approved'));
                }),
            Actions\Action::make('approve_agent')
                ->label(__('admin.approve_agent'))
                ->color('primary')
                ->icon('heroicon-o-briefcase')
                ->visible(fn ($record) => is_null($record->agent_verified_at) && filled($record->document_path))
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['agent_verified_at' => now()]);
                    $this->notify('success', __('admin.agent_approved'));
                }),
        ];
    }
}
