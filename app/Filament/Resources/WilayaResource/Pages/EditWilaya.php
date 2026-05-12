<?php

namespace App\Filament\Resources\WilayaResource\Pages;

use App\Filament\Resources\WilayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWilaya extends EditRecord
{
    protected static string $resource = WilayaResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
