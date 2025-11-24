<?php

namespace App\Filament\Clusters\Geography\Resources\Municipalities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MunicipalityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->label('Estado')
                    ->required(),
                TextInput::make('cve_mun')
                    ->label('CVE Municipio')
                    ->required(),
                TextInput::make('cve_geo')
                    ->label('CVE Geográfico')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
            ]);
    }
}
