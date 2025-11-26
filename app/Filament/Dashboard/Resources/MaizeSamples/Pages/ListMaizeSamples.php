<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaizeSamples extends ListRecords
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
