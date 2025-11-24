<?php

namespace App\Filament\Resources\MaizeSamples\Schemas;

use App\Models\Locality;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class MaizeSampleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la Muestra')
                    ->description('Ingrese la información correspondiente a la muestra de maíz.')
                    ->columnSpanFull()
                    ->collapsed(false)
                    ->schema([
                        Fieldset::make('Indentificación de la Muestra')
                            ->schema([
                                TextInput::make('sample_code')
                                    ->label('Código de Muestra')
                                    ->helperText('Debe ser único para cada muestra.')
                                    ->required(),
                                TextInput::make('sample_number')
                                    ->label('Número de Muestra')
                                    ->helperText('Debe ser único para cada muestra.')
                                    ->required()
                                    ->minValue(0)
                                    ->numeric(),
                            ]),
                        Fieldset::make('Recolector y Granjero')
                            ->schema([
                                Select::make('user_id')
                                    ->label('Recolector')
                                    ->relationship(
                                        name: 'user',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn($query) => $query->where('role', 'Recolector'),
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->disabledOn('edit')
                                    ->dehydrated(false)
                                    ->required(),
                                Select::make('farmer_name')
                                    ->label('Granjero')
                                    ->relationship(
                                        name: 'user',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn($query) => $query->where('role', 'Granjero'),
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->disabledOn('edit')
                                    ->dehydrated(false)
                                    ->required(),
                            ]),
                        Fieldset::make('Ubicación de la Muestra')
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
                                    ->label('Comunidad')
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
                        FieldSet::make('Detalles de la Muestra')
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
                            ]),
                    ]),
                Section::make('Sub-muestras')
                    ->description('Gestione las sub-muestras asociadas a esta muestra de maíz.')
                    ->columnSpanFull()
                    ->collapsed(true)
                    ->schema([
                        Repeater::make('subsamples')
                            ->label('Sub-muestras')
                            ->relationship('subsamples')
                            ->defaultItems(1)
                            ->addActionLabel('Agregar Sub-muestra')
                            ->schema([
                                Fieldset::make('Identificación')->schema([
                                    TextInput::make('subsample_number')
                                        ->label('N° Submuestra')
                                        ->numeric()
                                        ->minValue(0)
                                        ->required(),
                                ]),

                                // Categóricos
                                Fieldset::make('Categóricos')
                                    ->schema([
                                        Select::make('color_grano')
                                            ->label('Color de grano')
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

                                // Métricos
                                Fieldset::make('Métricas')
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
                                    ])
                                    ->columns(3),

                                // Se calcula en el modelo si no lo mandas
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
                                Fieldset::make('Imagen')
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('Imagen de la sub-muestra')
                                            ->image()                 // valida que sea imagen
                                            ->disk('public')          // usa storage público
                                            ->directory('subsamples') // carpeta destino
                                            ->imageEditor()           // editor integrado
                                            ->imagePreviewHeight('150')
                                            ->openable()
                                            ->downloadable()
                                            ->nullable()
                                            ->columnSpanFull()
                                            ->helperText('Opcional. Foto de la sub-muestra.'),
                                    ])
                                    ->columnSpanFull(),
                            ])
                    ]),
            ]);
    }
}
