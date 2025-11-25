<?php

namespace App\Filament\Resources\MaizeSamples\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaizeSamplesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sample_number')
                    ->label('# Muestra')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('collector.name')
                    ->label('Recolector')
                    ->sortable(),
                TextColumn::make('farmer.name')
                    ->label('Agricultor')
                    ->sortable(),
                TextColumn::make('municipality.name')
                    ->label('Municipio')
                    ->sortable(),
                TextColumn::make('locality.name')
                    ->label('Localidad')
                    ->sortable(),
                TextColumn::make('subsamples_count')
                    ->label('# Sub-muestras')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('collection_date')
                    ->label('Fecha de recolección')
                    ->date()
                    ->sortable(),
                /**TextColumn::make('latitude')
                    ->label('Latitud')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                TextColumn::make('longitude')
                    ->label('Longitud')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('variety_name')
                    ->label('Variedad')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
             **/
            ])
            ->filters([
                SelectFilter::make('locality')
                    ->label('Localidad')
                    ->preload()
                    ->searchable()
                    ->relationship('locality', 'name'),
                SelectFilter::make('farmer')
                    ->label('Agricultor')
                    ->preload()
                    ->searchable()
                    ->relationship('farmer', 'name'),
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
