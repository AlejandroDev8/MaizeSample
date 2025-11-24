<?php

namespace App\Filament\Clusters\Geography\Resources\States\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cve_ent')
                    ->label('CVE Entidad')
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->icon('heroicon-o-flag')
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('abbreviation')
                    ->label('Abreviatura')
                    ->icon('heroicon-o-building-office')
                    ->iconColor('primary')
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
