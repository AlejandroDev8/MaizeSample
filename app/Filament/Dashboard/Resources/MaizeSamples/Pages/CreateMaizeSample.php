<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMaizeSample extends CreateRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("Muestra de Maíz {$this->record->name} creada")
            ->body('La muestra de maíz ha sido creada exitosamente.');
    }
}
