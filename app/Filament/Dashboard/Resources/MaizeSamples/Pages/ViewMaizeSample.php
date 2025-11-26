<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaizeSample extends ViewRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
