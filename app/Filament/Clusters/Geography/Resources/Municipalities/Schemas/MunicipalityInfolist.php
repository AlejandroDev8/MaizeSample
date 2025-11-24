<?php

namespace App\Filament\Clusters\Geography\Resources\Municipalities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MunicipalityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('state.name')
                    ->label('Estado')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('primary'),
                TextEntry::make('cve_mun')
                    ->icon('heroicon-o-map')
                    ->iconColor('primary')
                    ->label('CVE Municipio'),
                TextEntry::make('cve_geo')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('CVE Geográfico'),
                TextEntry::make('name')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary')
                    ->label('Nombre'),
                TextEntry::make('updated_at')
                    ->icon('heroicon-o-clock')
                    ->iconColor('primary')
                    ->label('Última actualización')
                    ->dateTime(),
            ]);
    }
}
