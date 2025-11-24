<?php

namespace App\Filament\Clusters\User;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class UserCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Administración';

    protected static ?string $clusterBreadcrumb = 'Usuarios';

    protected static ?string $navigationLabel = 'Usuarios';
}
