<?php

namespace App\Filament\Resources\AdsPlanResource\Pages;

use App\Filament\Resources\AdsPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdsPlan extends EditRecord
{
    protected static string $resource = AdsPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
