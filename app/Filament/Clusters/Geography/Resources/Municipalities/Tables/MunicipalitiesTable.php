<?php

namespace App\Filament\Clusters\Geography\Resources\Municipalities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MunicipalitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('state.name')
                    ->label('Estado')
                    ->searchable()
                    ->icon('heroicon-o-building-office')
                    ->iconColor('primary')
                    ->sortable(),
                TextColumn::make('cve_mun')
                    ->icon('heroicon-o-map')
                    ->iconColor('primary')
                    ->label('CVE Municipio')
                    ->searchable(),
                TextColumn::make('cve_geo')
                    ->icon('heroicon-o-map-pin')
                    ->iconColor('primary')
                    ->label('CVE Geográfico')
                    ->searchable(),
                TextColumn::make('name')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary')
                    ->label('Nombre')
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
