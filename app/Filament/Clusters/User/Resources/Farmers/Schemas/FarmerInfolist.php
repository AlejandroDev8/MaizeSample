<?php

namespace App\Filament\Clusters\User\Resources\Farmers\Schemas;

use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FarmerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información')
                    ->collapsed(false)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->icon(Heroicon::OutlinedUserCircle)
                            ->iconColor('primary')
                            ->label('Nombre completo'),
                        TextEntry::make('email')
                            ->icon(Heroicon::OutlinedEnvelope)
                            ->iconColor('primary')
                            ->label('Correo electrónico'),
                        TextEntry::make('phone')
                            ->icon(Heroicon::OutlinedPhone)
                            ->iconColor('primary')
                            ->label('Teléfono'),
                        TextEntry::make('address')
                            ->icon(Heroicon::OutlinedHome)
                            ->iconColor('primary')
                            ->label('Dirección'),
                    ])
            ]);
    }
}
