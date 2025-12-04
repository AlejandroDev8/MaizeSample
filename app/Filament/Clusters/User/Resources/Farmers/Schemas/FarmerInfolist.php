<?php

namespace App\Filament\Clusters\User\Resources\Farmers\Schemas;

use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FarmerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información')
                    ->collapsed(false)
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->icon(Heroicon::OutlinedUserCircle)
                                    ->iconColor('primary')
                                    ->label('Nombre Completo'),
                                TextEntry::make('phone')
                                    ->icon(Heroicon::OutlinedPhone)
                                    ->iconColor('primary')
                                    ->label('Número de Teléfono'),
                                TextEntry::make('address')
                                    ->icon(Heroicon::OutlinedHomeModern)
                                    ->iconColor('primary')
                                    ->label('Dirección'),
                            ])
                    ]),
                Section::make('Detalles de Ubicación')
                    ->collapsed(false)
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('state.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Estado'),
                                TextEntry::make('municipality.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Municipio'),
                                TextEntry::make('locality.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Localidad'),
                            ]),
                    ]),
            ]);
    }
}
