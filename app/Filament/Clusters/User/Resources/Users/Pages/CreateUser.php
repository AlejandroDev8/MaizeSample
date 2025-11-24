<?php

namespace App\Filament\Clusters\User\Resources\Users\Pages;

use App\Filament\Clusters\User\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("Usuario {$this->record->name} creado")
            ->body('El usuario ha sido creado exitosamente.');
    }
}
