<?php

namespace App\Filament\Clusters\User\Resources\Farmers;

use App\Filament\Clusters\User\Resources\Farmers\Pages\CreateFarmer;
use App\Filament\Clusters\User\Resources\Farmers\Pages\EditFarmer;
use App\Filament\Clusters\User\Resources\Farmers\Pages\ListFarmers;
use App\Filament\Clusters\User\Resources\Farmers\Pages\ViewFarmer;
use App\Filament\Clusters\User\Resources\Farmers\Schemas\FarmerForm;
use App\Filament\Clusters\User\Resources\Farmers\Schemas\FarmerInfolist;
use App\Filament\Clusters\User\Resources\Farmers\Tables\FarmersTable;
use App\Filament\Clusters\User\UserCluster;
use App\Models\Farmer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FarmerResource extends Resource
{
    protected static ?string $model = Farmer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $cluster = UserCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Agricultores';

    protected static ?string $modelLabel = 'Agricultor';

    protected static ?string $pluralModelLabel = 'Agricultores';

    public static function form(Schema $schema): Schema
    {
        return FarmerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FarmerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmersTable::configure($table);
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
            'index' => ListFarmers::route('/'),
            'create' => CreateFarmer::route('/create'),
            'view' => ViewFarmer::route('/{record}'),
            'edit' => EditFarmer::route('/{record}/edit'),
        ];
    }
}
