<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples;

use App\Filament\Dashboard\Resources\MaizeSamples\Pages\CreateMaizeSample;
use App\Filament\Dashboard\Resources\MaizeSamples\Pages\EditMaizeSample;
use App\Filament\Dashboard\Resources\MaizeSamples\Pages\ListMaizeSamples;
use App\Filament\Dashboard\Resources\MaizeSamples\Pages\ViewMaizeSample;
use App\Filament\Dashboard\Resources\MaizeSamples\Schemas\MaizeSampleForm;
use App\Filament\Dashboard\Resources\MaizeSamples\Schemas\MaizeSampleInfolist;
use App\Filament\Dashboard\Resources\MaizeSamples\Tables\MaizeSamplesTable;
use App\Models\MaizeSample;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaizeSampleResource extends Resource
{
    protected static ?string $model = MaizeSample::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MaizeSampleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaizeSampleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaizeSamplesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaizeSamples::route('/'),
            'create' => CreateMaizeSample::route('/create'),
            'view' => ViewMaizeSample::route('/{record}'),
            'edit' => EditMaizeSample::route('/{record}/edit'),
        ];
    }
}
