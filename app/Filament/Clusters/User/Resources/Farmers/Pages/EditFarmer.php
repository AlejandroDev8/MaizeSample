<?php

namespace App\Filament\Clusters\User\Resources\Farmers\Pages;

use App\Filament\Clusters\User\Resources\Farmers\FarmerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditFarmer extends EditRecord
{
    protected static string $resource = FarmerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("El agricultor {$this->record->name} ha sido actualizado exitosamente.")
            ->body("El agricultor {$this->record->name} ha sido actualizado exitosamente.");
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
