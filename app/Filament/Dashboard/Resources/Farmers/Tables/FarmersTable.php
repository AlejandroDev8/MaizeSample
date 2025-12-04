<?php

namespace App\Filament\Dashboard\Resources\Farmers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                // TextColumn::make('address')
                //     ->icon(Heroicon::OutlinedMapPin)
                //     ->iconColor('primary')
                //     ->label('Dirección')
                //     ->searchable(),
                TextColumn::make('state.name')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->iconColor('primary')
                    ->label('Estado')
                    ->searchable(),
                TextColumn::make('municipality.name')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->iconColor('primary')
                    ->label('Municipio')
                    ->searchable(),
                TextColumn::make('locality.name')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->iconColor('primary')
                    ->label('Localidad')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('municipality_id')
                    ->label('Municipio')
                    ->relationship('municipality', 'name'),
                SelectFilter::make('locality_id')
                    ->label('Localidad')
                    ->relationship('locality', 'name'),
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
