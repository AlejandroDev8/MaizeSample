<?php

namespace App\Filament\Dashboard\Resources\Farmers\Pages;

use App\Filament\Dashboard\Resources\Farmers\FarmerResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateFarmer extends CreateRecord
{
    protected static string $resource = FarmerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("Agricultor {$this->record->name} creado")
            ->body('El agricultor ha sido creado exitosamente.');
    }
}
