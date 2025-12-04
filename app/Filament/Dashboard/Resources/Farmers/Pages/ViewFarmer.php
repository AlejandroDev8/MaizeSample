<?php

namespace App\Filament\Dashboard\Resources\Farmers\Pages;

use App\Filament\Dashboard\Resources\Farmers\FarmerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFarmer extends ViewRecord
{
    protected static string $resource = FarmerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
