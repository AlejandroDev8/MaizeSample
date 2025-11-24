<?php

namespace App\Filament\Clusters\Geography\Resources\Localities;

use App\Filament\Clusters\Geography\GeographyCluster;
use App\Filament\Clusters\Geography\Resources\Localities\Pages\CreateLocality;
use App\Filament\Clusters\Geography\Resources\Localities\Pages\EditLocality;
use App\Filament\Clusters\Geography\Resources\Localities\Pages\ListLocalities;
use App\Filament\Clusters\Geography\Resources\Localities\Pages\ViewLocality;
use App\Filament\Clusters\Geography\Resources\Localities\Schemas\LocalityForm;
use App\Filament\Clusters\Geography\Resources\Localities\Schemas\LocalityInfolist;
use App\Filament\Clusters\Geography\Resources\Localities\Tables\LocalitiesTable;
use App\Models\Locality;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LocalityResource extends Resource
{
    protected static ?string $model = Locality::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Localidades';

    protected static ?string $modelLabel = 'Localidad';

    protected static ?string $pluralModelLabel = 'Localidades';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = GeographyCluster::class;

    public static function form(Schema $schema): Schema
    {
        return LocalityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LocalityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocalitiesTable::configure($table);
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
            'index' => ListLocalities::route('/'),
            'create' => CreateLocality::route('/create'),
            'view' => ViewLocality::route('/{record}'),
            'edit' => EditLocality::route('/{record}/edit'),
        ];
    }
}
