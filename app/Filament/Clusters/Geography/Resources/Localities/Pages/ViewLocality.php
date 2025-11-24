<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Pages;

use App\Filament\Clusters\Geography\Resources\Localities\LocalityResource;
use Filament\Actions\EditAction;
use \Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewLocality extends ViewRecord
{
    protected static string $resource = LocalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label('Regresar')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
