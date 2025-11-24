<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LocalityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('municipality.name')
                    ->icon('heroicon-o-building-office-2')
                    ->iconColor('primary')
                    ->label('Localidad'),
                TextEntry::make('cve_loc')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->label('CVE Localidad'),
                TextEntry::make('cve_geo')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->label('CVE Geográfico'),
                TextEntry::make('name')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary')
                    ->label('Nombre'),
                TextEntry::make('lat')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('Latitud')
                    ->numeric(),
                TextEntry::make('lng')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('Longitud')
                    ->numeric(),
                TextEntry::make('updated_at')
                    ->icon('heroicon-o-clock')
                    ->iconColor('primary')
                    ->label('Última actualización')
                    ->dateTime(),
            ]);
    }
}
