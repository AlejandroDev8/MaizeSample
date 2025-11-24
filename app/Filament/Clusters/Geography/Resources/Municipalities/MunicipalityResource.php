<?php

namespace App\Filament\Clusters\Geography\Resources\Municipalities;

use App\Filament\Clusters\Geography\GeographyCluster;
use App\Filament\Clusters\Geography\Resources\Municipalities\Pages\CreateMunicipality;
use App\Filament\Clusters\Geography\Resources\Municipalities\Pages\EditMunicipality;
use App\Filament\Clusters\Geography\Resources\Municipalities\Pages\ListMunicipalities;
use App\Filament\Clusters\Geography\Resources\Municipalities\Pages\ViewMunicipality;
use App\Filament\Clusters\Geography\Resources\Municipalities\Schemas\MunicipalityForm;
use App\Filament\Clusters\Geography\Resources\Municipalities\Schemas\MunicipalityInfolist;
use App\Filament\Clusters\Geography\Resources\Municipalities\Tables\MunicipalitiesTable;

use App\Models\Municipality;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MunicipalityResource extends Resource
{
    protected static ?string $model = Municipality::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Municipios';

    protected static ?string $modelLabel = 'Municipio';

    protected static ?string $pluralModelLabel = 'Municipios';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = GeographyCluster::class;

    public static function form(Schema $schema): Schema
    {
        return MunicipalityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MunicipalityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MunicipalitiesTable::configure($table);
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
            'index' => ListMunicipalities::route('/'),
            'create' => CreateMunicipality::route('/create'),
            'view' => ViewMunicipality::route('/{record}'),
            'edit' => EditMunicipality::route('/{record}/edit'),
        ];
    }
}
