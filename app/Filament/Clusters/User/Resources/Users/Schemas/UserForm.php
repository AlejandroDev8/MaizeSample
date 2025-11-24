<?php

namespace App\Filament\Clusters\User\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->collapsed(false)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre completo')
                            ->helperText('Ingresa el nombre completo del usuario.')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->helperText('Ingresa el correo electrónico del usuario.')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->hiddenOn('edit')
                            ->label('Contraseña')
                            ->helperText('Ingresa la contraseña del usuario.')
                            ->revealable()
                            ->password()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->helperText('Ingresa el número de teléfono del usuario.')
                            ->tel(),
                    ]),

                Section::make('Roles para el usuario')
                    ->collapsed(false)
                    ->schema([
                        Select::make('role')
                            ->label('Rol')
                            ->helperText('Selecciona el rol del usuario.')
                            ->options([
                                'Administrador' => 'Administrador',
                                'Recolector' => 'Recolector',
                            ])
                            ->required(),
                    ])
            ]);
    }
}
