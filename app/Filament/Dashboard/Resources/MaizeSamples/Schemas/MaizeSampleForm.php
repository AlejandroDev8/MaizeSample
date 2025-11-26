<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaizeSampleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('farmer_id')
                    ->relationship('farmer', 'name')
                    ->required(),
                Select::make('municipality_id')
                    ->relationship('municipality', 'name')
                    ->required(),
                Select::make('locality_id')
                    ->relationship('locality', 'name')
                    ->required(),
                TextInput::make('code'),
                TextInput::make('sample_number')
                    ->numeric(),
                DatePicker::make('collection_date'),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('variety_name'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
