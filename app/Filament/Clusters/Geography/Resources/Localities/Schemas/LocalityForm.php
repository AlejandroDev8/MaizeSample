<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LocalityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('municipality_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cve_loc')
                    ->required(),
                TextInput::make('cve_geo')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Toggle::make('urban_area'),
                TextInput::make('lat')
                    ->numeric(),
                TextInput::make('lng')
                    ->numeric(),
            ]);
    }
}
