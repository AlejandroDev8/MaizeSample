<?php

namespace App\Filament\Dashboard\Resources\Farmers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FarmerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('municipality_id')
                    ->required()
                    ->numeric(),
                TextInput::make('locality_id')
                    ->required()
                    ->numeric(),
                Textarea::make('address')
                    ->columnSpanFull(),
            ]);
    }
}
