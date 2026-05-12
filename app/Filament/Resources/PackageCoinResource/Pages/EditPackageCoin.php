<?php

namespace App\Filament\Resources\PackageCoinResource\Pages;

use App\Filament\Resources\PackageCoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageCoin extends EditRecord
{
    protected static string $resource = PackageCoinResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
