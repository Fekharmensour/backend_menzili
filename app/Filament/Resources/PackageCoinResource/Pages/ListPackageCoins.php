<?php

namespace App\Filament\Resources\PackageCoinResource\Pages;

use App\Filament\Resources\PackageCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackageCoins extends ListRecords
{
    protected static string $resource = PackageCoinResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
