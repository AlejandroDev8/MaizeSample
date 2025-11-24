<?php

namespace App\Filament\Clusters\Geography\Resources\Municipalities\Pages;

use App\Filament\Clusters\Geography\Resources\Municipalities\MunicipalityResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMunicipality extends ViewRecord
{
    protected static string $resource = MunicipalityResource::class;

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
