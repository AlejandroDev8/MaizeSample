<?php

namespace App\Filament\Resources\MaizeSamples\Pages;

use App\Filament\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

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
            Action::make('back')
                ->label('Volver')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
            ViewAction::make('view')
                ->label('Ver')
                ->icon(Heroicon::OutlinedEye)
                ->color('primary')
                ->url($this->getResource()::getUrl('view', ['record' => $this->getRecord()])),
            DeleteAction::make(),
        ];
    }
}
