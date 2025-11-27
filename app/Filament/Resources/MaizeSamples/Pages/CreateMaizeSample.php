<?php

namespace App\Filament\Resources\MaizeSamples\Pages;

use App\Filament\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMaizeSample extends CreateRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("Muestra de Maíz {$this->record->name} creada")
            ->body('La muestra de maíz ha sido creada exitosamente.');
    }
}
