<?php

namespace App\Filament\Dashboard\Resources\Farmers\Pages;

use App\Filament\Dashboard\Resources\Farmers\FarmerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFarmer extends CreateRecord
{
    protected static string $resource = FarmerResource::class;
}
