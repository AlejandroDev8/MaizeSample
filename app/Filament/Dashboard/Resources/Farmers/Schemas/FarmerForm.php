<?php

namespace App\Filament\Dashboard\Resources\Farmers\Schemas;

use App\Models\Locality;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class FarmerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Información del Agricultor')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),
                        Textarea::make('address')
                            ->label('Dirección')
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),
                Fieldset::make('Ubicación')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('state_id')
                            ->label('Estado')
                            ->relationship('state', 'name')
                            ->preload(),
                        Select::make('municipality_id')
                            ->label('Municipio')
                            ->relationship('municipality', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                $set('locality_id', null);
                            }),
                        Select::make('locality_id')
                            ->label('Localidad')
                            ->options(fn(Get $get): Collection => Locality::query()->where('municipality_id', $get('municipality_id'))->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                    ]),
            ]);
    }
}
