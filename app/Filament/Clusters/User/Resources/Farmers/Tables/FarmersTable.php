<?php

namespace App\Filament\Clusters\User\Resources\Farmers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FarmersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->icon(Heroicon::OutlinedUserCircle)
                    ->iconColor('primary')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('phone')
                    ->icon(Heroicon::OutlinedPhone)
                    ->iconColor('primary')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('email')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->iconColor('primary')
                    ->label('Correo electrónico')
                    ->searchable(),
                TextColumn::make('address')
                    ->icon(Heroicon::OutlinedMapPin)
                    ->iconColor('primary')
                    ->label('Dirección')
                    ->searchable(),
            ])
            ->filters([
                //
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
