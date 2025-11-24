<?php

namespace App\Filament\Clusters\User\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Usuario')
                    ->columnSpanFull()
                    ->columns(2)
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre Completo')
                            ->icon(Heroicon::OutlinedUserCircle)
                            ->iconColor('primary'),
                        TextEntry::make('role')
                            ->label('Rol')
                            ->icon(Heroicon::OutlinedShieldCheck)
                            ->color(fn(string $state): string => match ($state) {
                                'Administrador' => 'success',
                                'Recolector' => 'warning',
                                default => 'gray',
                            })
                            ->badge(),
                        TextEntry::make('email')
                            ->label('Correo Electrónico')
                            ->icon(Heroicon::OutlinedEnvelope)
                            ->iconColor('primary'),
                        TextEntry::make('phone')
                            ->label('Teléfono')
                            ->icon(Heroicon::OutlinedPhone)
                            ->iconColor('primary'),
                        TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->icon(Heroicon::OutlinedCalendar)
                            ->iconColor('primary')
                            ->date(),
                        TextEntry::make('updated_at')
                            ->label('Última Actualización')
                            ->icon(Heroicon::OutlinedClock)
                            ->iconColor('primary')
                            ->date(),
                    ])
            ]);
    }
}
