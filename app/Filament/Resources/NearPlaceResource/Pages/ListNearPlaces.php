<?php

namespace App\Filament\Resources\NearPlaceResource\Pages;

use App\Filament\Resources\NearPlaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNearPlaces extends ListRecords
{
    protected static string $resource = NearPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
