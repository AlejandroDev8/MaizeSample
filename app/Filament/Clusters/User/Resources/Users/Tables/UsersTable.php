<?php

namespace App\Filament\Clusters\User\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->icon(Heroicon::OutlinedUserCircle)
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Rol')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->color(fn(string $state): string => match ($state) {
                        'Administrador' => 'success',
                        'Recolector' => 'warning',
                        default => 'gray',
                    })
                    ->badge()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->icon(Heroicon::OutlinedPhone)
                    ->iconColor('primary')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Rol')
                    ->options([
                        'Administrador' => 'Administrador',
                        'Recolector' => 'Recolector',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
