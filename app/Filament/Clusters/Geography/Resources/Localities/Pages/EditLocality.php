<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Pages;

use App\Filament\Clusters\Geography\Resources\Localities\LocalityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLocality extends EditRecord
{
    protected static string $resource = LocalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
