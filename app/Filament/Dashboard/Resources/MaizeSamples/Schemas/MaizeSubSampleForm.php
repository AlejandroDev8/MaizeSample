<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaizeSubSampleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sub-Muestra')
                    ->description('Captura una o varias sub-muestras con sus mediciones.')
                    ->collapsed(false)
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('sub_sample')
                            ->label('Sub-Muestras')
                            ->relationship('subsamples')
                            ->defaultItems(1)
                            ->addActionLabel('Agregar Sub-Muestra')
                            ->schema([
                                Fieldset::make('Identificación')
                                    ->schema([
                                        TextInput::make('subsample_number')
                                            ->label('Número de Sub-Muestra')
                                            ->required()
                                            ->numeric()
                                            ->required(),
                                    ]),
                                Fieldset::make('Características Categóricas')
                                    ->schema([
                                        Select::make('color_grano')
                                            ->label('Color del grano')
                                            ->options([
                                                'BLANCO',
                                                'AMARILLO',
                                                'ROJO',
                                                'MORADO',
                                                'AZUL',
                                                'NEGRO'
                                            ]),
                                        Select::make('color_olote')
                                            ->label('Color de olote')
                                            ->options([
                                                'BLANCO',
                                                'ROSA',
                                                'ROJO',
                                                'CAFÉ'
                                            ]),
                                        Select::make('tipo_grano')
                                            ->label('Tipo de grano')
                                            ->options([
                                                'Dentado',
                                                'Duro',
                                                'Reventador',
                                                'Harinoso'
                                            ]),
                                        TextInput::make('forma_corona_grano')
                                            ->label('Forma de la corona')
                                            ->helperText('Puntiaguda, redondeada, etc.'),
                                        TextInput::make('color_dorsal_grano')
                                            ->label('Color dorsal')
                                            ->helperText('Color del lado convexo del grano.'),
                                        TextInput::make('color_endospermo_grano')
                                            ->label('Color del endospermo')
                                            ->helperText('Color del interior del grano.'),
                                        TextInput::make('arreglo_hileras_grano')
                                            ->label('Arreglo de hileras')
                                            ->helperText('Regular, irregular, etc.')
                                            ->columnSpanFull(),
                                    ]),
                                Fieldset::make('Métricas')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('diametro_mazorca_mm')
                                            ->label('Diámetro mazorca (mm)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('largo_mazorca_mm')
                                            ->label('Largo mazorca (mm)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('peso_mazorca_g')
                                            ->label('Peso de mazorca (g)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('peso_grano_50_g')
                                            ->label('Peso de grano 50 (g)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('num_hileras')
                                            ->label('N° de hileras')
                                            ->numeric()->minValue(0),
                                        TextInput::make('num_granos_por_hilera')
                                            ->label('N° granos/hilera')
                                            ->numeric()->minValue(0),
                                        TextInput::make('grosor_grano_mm')
                                            ->label('Grosor grano (mm)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('ancho_grano_mm')
                                            ->label('AGR (mm)')
                                            ->numeric()->minValue(0),
                                        TextInput::make('longitud_grano_mm')
                                            ->label('LGR (mm)')
                                            ->numeric()->minValue(0),
                                    ]),
                                Fieldset::make('Cálculos')
                                    ->schema([
                                        TextInput::make('indice_lgr_agr')
                                            ->label('Índice LGR/AGR')
                                            ->disabled()
                                            ->helperText('Se calcula automáticamente al guardar si LGR y AGR están capturados.'),

                                        TextInput::make('volumen_grano_50_ml')
                                            ->label('Volumen 50 semillas (ml)')
                                            ->numeric()
                                            ->minValue(0),
                                    ]),
                                Fieldset::make('Imagen de la Sub-Muestra')
                                    ->columnSpanFull()
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('Imagen de la sub-muestra')
                                            ->image()
                                            ->disk('public')
                                            ->directory('subsamples')
                                            ->imageEditor()
                                            ->imagePreviewHeight('150')
                                            ->openable()
                                            ->downloadable()
                                            ->nullable()
                                            ->columnSpanFull(),
                                    ])
                            ])
                    ])
            ]);
    }
}
