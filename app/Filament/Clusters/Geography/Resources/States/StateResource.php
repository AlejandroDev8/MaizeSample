<?php

namespace App\Filament\Clusters\Geography\Resources\States;

use App\Filament\Clusters\Geography\GeographyCluster;
use App\Filament\Clusters\Geography\Resources\States\Pages\CreateState;
use App\Filament\Clusters\Geography\Resources\States\Pages\EditState;
use App\Filament\Clusters\Geography\Resources\States\Pages\ListStates;
use App\Filament\Clusters\Geography\Resources\States\Pages\ViewState;
use App\Filament\Clusters\Geography\Resources\States\Schemas\StateForm;
use App\Filament\Clusters\Geography\Resources\States\Schemas\StateInfolist;
use App\Filament\Clusters\Geography\Resources\States\Tables\StatesTable;

use App\Models\State;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Estados';

    protected static ?string $modelLabel = 'Estado';

    protected static ?string $pluralModelLabel = 'Estados';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = GeographyCluster::class;

    public static function form(Schema $schema): Schema
    {
        return StateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatesTable::configure($table);
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
            'index' => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'view' => ViewState::route('/{record}'),
            'edit' => EditState::route('/{record}/edit'),
        ];
    }
}
