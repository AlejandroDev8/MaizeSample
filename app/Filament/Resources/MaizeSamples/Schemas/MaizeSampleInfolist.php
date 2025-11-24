<?php

namespace App\Filament\Resources\MaizeSamples\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MaizeSampleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('farmer.name')
                    ->numeric(),
                TextEntry::make('municipality.name')
                    ->numeric(),
                TextEntry::make('locality.name')
                    ->numeric(),
                TextEntry::make('code'),
                TextEntry::make('sample_number')
                    ->numeric(),
                TextEntry::make('collection_date')
                    ->date(),
                TextEntry::make('latitude')
                    ->numeric(),
                TextEntry::make('longitude')
                    ->numeric(),
                TextEntry::make('variety_name'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
