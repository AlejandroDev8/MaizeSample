<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMaizeSample extends EditRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
