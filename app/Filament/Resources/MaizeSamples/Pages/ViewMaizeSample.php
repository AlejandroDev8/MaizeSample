<?php

namespace App\Filament\Resources\MaizeSamples\Pages;

use App\Filament\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaizeSample extends ViewRecord
{
    protected static string $resource = MaizeSampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label('Regresar')
                ->url($this->getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left')
                ->color('gray'),
        ];
    }

    public function getHeading(): string
    {
        $n = $this->record->sample_number ?? $this->record->id;
        return "Muestra #{$n}";
    }

    public function getTitle(): string
    {
        return $this->getHeading();
    }
}
