<?php

namespace App\Filament\Resources\RentDurationResource\Pages;

use App\Filament\Resources\RentDurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentDurations extends ListRecords
{
    protected static string $resource = RentDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
