<?php

namespace App\Filament\Clusters\Geography\Resources\States\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('cve_ent')
                    ->label('CVE Entidad')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary'),
                TextEntry::make('name')
                    ->label('Nombre')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary'),
                TextEntry::make('abbreviation')
                    ->label('Abreviatura')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('primary'),
                TextEntry::make('updated_at')
                    ->label('Última Actualización')
                    ->icon('heroicon-o-clock')
                    ->iconColor('primary')
                    ->dateTime(),
            ]);
    }
}
