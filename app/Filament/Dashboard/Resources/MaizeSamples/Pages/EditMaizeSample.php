<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMaizeSample extends EditRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title("La muestra de maíz {$this->record->name} ha sido actualizada exitosamente.")
            ->body('La muestra de maíz ha sido actualizada exitosamente.');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
