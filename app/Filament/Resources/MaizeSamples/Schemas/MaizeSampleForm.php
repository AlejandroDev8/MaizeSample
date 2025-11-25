<?php

namespace App\Filament\Resources\MaizeSamples\Schemas;

use App\Models\Locality;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MaizeSampleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la muestra')
                    ->description('Captura los datos generales de la muestra')
                    ->columnSpanFull()
                    ->collapsed(false)
                    ->schema([
                        Fieldset::make('Información')
                            ->schema([
                                TextInput::make('code')
                                    ->label('Código')
                                    ->required()
                                    ->maxLength(50),
                                // TextInput::make('sample_number')
                                //     ->label('Número de muestra')
                                //     ->required()
                                //     ->numeric(),
                            ]),
                        Fieldset::make('Recolector y Agricultor')
                            ->schema([
                                TextInput::make('collector_name')
                                    ->label('Recolector')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateHydrated(function (TextInput $component, Get $get, $state) {
                                        // En edición: obtener el nombre del usuario relacionado
                                        if ($userId = $get('user_id')) {
                                            $user = User::find($userId);
                                            $component->state($user?->name ?? 'Usuario no encontrado');
                                        } else {
                                            // En creación: usar el usuario autenticado
                                            $component->state(Auth::user()?->name ?? 'Usuario no identificado');
                                        }
                                    }),
                                Hidden::make('user_id')
                                    ->default(fn() => Auth::id()),
                                Select::make('farmer_id')
                                    ->label('Agricultor')
                                    ->relationship('farmer', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                            ]),
                        Fieldset::make('Ubicación')
                            ->schema([
                                Select::make('municipality_id')
                                    ->label('Municipio')
                                    ->relationship('municipality', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('locality_id', null);
                                    }),
                                Select::make('locality_id')
                                    ->label('Localidad')
                                    ->options(fn(Get $get): Collection => Locality::query()->where('municipality_id', $get('municipality_id'))->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required(),
                                TextInput::make('latitude')
                                    ->label('Latitud (N)')
                                    ->required()
                                    ->numeric()
                                    ->step('0.000001'),
                                TextInput::make('longitude')
                                    ->label('Longitud (O)')
                                    ->required()
                                    ->numeric()
                                    ->step('0.000001'),
                            ]),
                        Fieldset::make('Detalles de la muestra')
                            ->schema([
                                DatePicker::make('collection_date')
                                    ->format('d-M-Y')
                                    ->displayFormat('d-M-Y')
                                    ->timezone('America/Mexico_City')
                                    ->required()
                                    ->label('Fecha de colecta')
                                    ->columnSpan(1),
                                TextInput::make('variety_name')
                                    ->label('Nombre de la variedad')
                                    ->required()
                                    ->columnSpan(1),
                                Textarea::make('notes')
                                    ->label('Notas')
                                    ->autosize()
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                            ])
                    ]),

                // Agregar el formulario de sub-muestras
                ...MaizeSubSampleForm::configure(new Schema())->getComponents(),
            ]);
    }
}
