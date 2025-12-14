<?php

namespace App\Filament\Clusters\Geography\Resources\Localities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LocalitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('municipality.name')
                    ->icon('heroicon-o-building-office-2')
                    ->iconColor('primary')
                    ->label('Municipio')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cve_loc')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->label('CVE Localidad')
                    ->searchable(),
                TextColumn::make('cve_geo')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->label('CVE Geográfico')
                    ->searchable(),
                TextColumn::make('name')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary')
                    ->label('Nombre')
                    ->searchable(),
                // IconColumn::make('urban_area')
                //     ->boolean(),
                TextColumn::make('lat')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('Latitud')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lng')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('Longitud')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('municipality')
                    ->label('Municipio')
                    ->preload()
                    ->searchable()
                    ->relationship('municipality', 'name'),
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
