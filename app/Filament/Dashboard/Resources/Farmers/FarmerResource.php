<?php

namespace App\Filament\Dashboard\Resources\Farmers;

use App\Filament\Dashboard\Resources\Farmers\Pages\CreateFarmer;
use App\Filament\Dashboard\Resources\Farmers\Pages\EditFarmer;
use App\Filament\Dashboard\Resources\Farmers\Pages\ListFarmers;
use App\Filament\Dashboard\Resources\Farmers\Pages\ViewFarmer;
use App\Filament\Dashboard\Resources\Farmers\Schemas\FarmerForm;
use App\Filament\Dashboard\Resources\Farmers\Schemas\FarmerInfolist;
use App\Filament\Dashboard\Resources\Farmers\Tables\FarmersTable;
use App\Models\Farmer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FarmerResource extends Resource
{
    protected static ?string $model = Farmer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
