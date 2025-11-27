<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Pages;

use App\Filament\Dashboard\Resources\MaizeSamples\MaizeSampleResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewMaizeSample extends ViewRecord
{
    protected static string $resource = MaizeSampleResource::class;

    public function getHeading(): string
    {
        $n = $this->record->sample_number ?? $this->record->id;
        return "Muestra #{$n}";
    }

    public function getTitle(): string
    {
        return $this->getHeading();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
            EditAction::make('edit')
                ->label('Editar')
                ->icon(Heroicon::OutlinedPencil)
                ->color('primary')
                ->url($this->getResource()::getUrl('edit', ['record' => $this->getRecord()])),
        ];
    }
}
