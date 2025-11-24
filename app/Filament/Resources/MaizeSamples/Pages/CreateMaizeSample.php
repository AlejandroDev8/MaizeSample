<?php

namespace App\Filament\Resources\MaizeSamples\Pages;

use App\Filament\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMaizeSample extends CreateRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return dd($data);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Muestra creada')
            ->body('La muestra de maíz se creó correctamente.');
    }
}
