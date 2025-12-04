<?php

namespace App\Filament\Dashboard\Resources\MaizeSamples\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MaizeSampleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Responables')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('collector.name')
                                    ->icon(Heroicon::OutlinedUserCircle)
                                    ->iconColor('primary')
                                    ->label('Recolector'),
                                TextEntry::make('farmer.name')
                                    ->icon(Heroicon::OutlinedUserGroup)
                                    ->iconColor('primary')
                                    ->label('Agricultor'),
                            ])
                    ]),
                Section::make('Datos Generales / Detalles de Ubicación')
                    ->columnSpanFull()
                    ->collapsed(false)
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('collection_date')
                                    ->label('Fecha de colecta')
                                    ->icon(Heroicon::OutlinedCalendarDays)
                                    ->iconColor('primary')
                                    ->date('d-M-Y'),
                                TextEntry::make('state.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Estado'),
                                TextEntry::make('municipality.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Municipio'),
                                TextEntry::make('locality.name')
                                    ->icon(Heroicon::OutlinedBuildingOffice2)
                                    ->iconColor('primary')
                                    ->label('Localidad'),
                                TextEntry::make('latitude')
                                    ->label('Latitud')
                                    ->icon(Heroicon::OutlinedMapPin)
                                    ->iconColor('primary'),
                                TextEntry::make('longitude')
                                    ->label('Longitud')
                                    ->icon(Heroicon::OutlinedMapPin)
                                    ->iconColor('primary'),
                            ]),
                    ]),
                Section::make('Variedad / Notas')
                    ->columnSpanFull()
                    ->collapsed(false)
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('variety_name')
                                ->label('Nombre de la variedad')
                                ->placeholder('—'),
                            TextEntry::make('notes')
                                ->label('Notas')
                                ->markdown()
                                ->placeholder('No hay notas adicionales')
                                ->color(fn($state) => empty($state) ? 'gray' : null),
                        ]),
                    ]),
                Section::make('Sub-Muestras')
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('subsamples')
                            ->label('Sub-Muestras')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextEntry::make('subsample_number')
                                            ->label('N° Sub-Muestra'),
                                        TextEntry::make('color_grano')
                                            ->label('Color grano'),
                                        TextEntry::make('tipo_grano')
                                            ->label('Tipo'),
                                        TextEntry::make('arreglo_hileras_grano')
                                            ->label('Arreglo hileras'),
                                    ]),
                                Grid::make(4)->schema([
                                    TextEntry::make('diametro_mazorca_mm')
                                        ->label('Ø mazorca (mm)'),
                                    TextEntry::make('largo_mazorca_mm')
                                        ->label('Largo mazorca (mm)'),
                                    TextEntry::make('peso_mazorca_g')
                                        ->label('Peso mazorca (g)'),
                                    TextEntry::make('peso_grano_50_g')
                                        ->label('Peso 50 granos (g)'),
                                ]),
                                Grid::make(4)->schema([
                                    TextEntry::make('num_hileras')
                                        ->label('N° hileras'),
                                    TextEntry::make('num_granos_por_hilera')
                                        ->label('N° granos/hilera'),
                                    TextEntry::make('ancho_grano_mm')
                                        ->label('AGR (mm)'),
                                    TextEntry::make('longitud_grano_mm')
                                        ->label('LGR (mm)'),
                                ]),
                                Grid::make(4)->schema([
                                    TextEntry::make('grosor_grano_mm')
                                        ->label('Grosor (mm)'),
                                    TextEntry::make('indice_lgr_agr')
                                        ->label('Índice LGR/AGR'),
                                    TextEntry::make('volumen_grano_50_ml')
                                        ->label('Volumen 50 (ml)'),
                                    TextEntry::make('color_endospermo_grano')
                                        ->label('Color endospermo'),
                                ]),
                                Grid::make(3)->schema([
                                    TextEntry::make('color_olote')
                                        ->label('Color olote'),
                                    TextEntry::make('color_dorsal_grano')
                                        ->label('Color dorsal'),
                                    TextEntry::make('forma_corona_grano')
                                        ->label('Forma corona'),
                                ]),
                                // === Imagen de la sub-muestra (usa tu accessor image_url) ===
                                ImageEntry::make('image_path')
                                    ->label('Foto')
                                    ->disk('public')          // <- IMPORTANTÍSIMO
                                    ->imageHeight('200px')
                                    ->columnSpanFull(),
                                // DEBUG opcional: ver la URL que está usando
                                // TextEntry::make('image_path')
                                //     ->label('URL foto (debug)')
                                //     ->columnSpanFull(),
                            ])
                    ])
            ]);
    }
}
