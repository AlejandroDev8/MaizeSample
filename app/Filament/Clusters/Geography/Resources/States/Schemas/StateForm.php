<?php

namespace App\Filament\Clusters\Geography\Resources\States\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cve_ent')
                    ->label('CVE Entidad')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('abbreviation')
                    ->label('Abreviatura'),
            ]);
    }
}
