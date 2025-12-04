<?php

namespace App\Filament\Dashboard\Resources\Farmers\Pages;

use App\Filament\Dashboard\Resources\Farmers\FarmerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmers extends ListRecords
{
    protected static string $resource = FarmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
