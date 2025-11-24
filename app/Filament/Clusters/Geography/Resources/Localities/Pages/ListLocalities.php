<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Pages;

use App\Filament\Clusters\Geography\Resources\Localities\LocalityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLocalities extends ListRecords
{
    protected static string $resource = LocalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
