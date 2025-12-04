<?php

namespace App\Filament\Dashboard\Resources\Farmers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FarmerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('state_id')
                    ->numeric(),
                TextEntry::make('municipality_id')
                    ->numeric(),
                TextEntry::make('locality_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
