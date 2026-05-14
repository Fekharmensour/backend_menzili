<?php

namespace App\Filament\Resources\AdsPlanResource\Pages;

use App\Filament\Resources\AdsPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdsPlans extends ListRecords
{
    protected static string $resource = AdsPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
