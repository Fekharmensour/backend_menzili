<?php

namespace App\Filament\Resources\RentDurationResource\Pages;

use App\Filament\Resources\RentDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentDuration extends EditRecord
{
    protected static string $resource = RentDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
