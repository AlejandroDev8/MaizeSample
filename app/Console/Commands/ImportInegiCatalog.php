<?php

namespace App\Console\Commands;

use App\Models\Locality;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportInegiCatalog extends Command
{
    protected $signature = 'inegi:import {--fresh : Clear the existing data before import}';
    protected $description = 'Import States, Municipalities, and Localities from INEGI';

    private string $base = 'https://gaia.inegi.org.mx/wscatgeo/v2';

    // Clave de San Luis Potosí en el catálogo de INEGI
    private const TARGET_STATE_CODE = '24';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            DB::statement('TRUNCATE localities RESTART IDENTITY CASCADE');
            DB::statement('TRUNCATE municipalities RESTART IDENTITY CASCADE');
            DB::statement('TRUNCATE states RESTART IDENTITY CASCADE');
        }

        // 1) Estados
        $stateRows = Http::retry(3, 300)->get("{$this->base}/mgee/")->json('datos') ?? [];

        foreach ($stateRows as $stateRow) {

            // Saltar todos los estados que no sean San Luis Potosí
            if (($stateRow['cve_ent'] ?? null) !== self::TARGET_STATE_CODE) {
                continue;
            }

            $stateModel = State::updateOrCreate(
                ['cve_ent' => $stateRow['cve_ent']],
                [
                    'name'         => $stateRow['nomgeo'] ?? $stateRow['cve_ent'],
                    'abbreviation' => $stateRow['nom_abrev'] ?? null,
                ]
            );

            // 2) Municipios de San Luis Potosí
            $munRows = Http::retry(3, 300)
                ->get("{$this->base}/mgem/{$stateRow['cve_ent']}")
                ->json('datos') ?? [];

            foreach ($munRows as $munRow) {
                $munModel = Municipality::updateOrCreate(
                    ['state_id' => $stateModel->id, 'cve_mun' => $munRow['cve_mun']],
                    [
                        'cve_geo' => $munRow['cvegeo'],
                        'name'    => $munRow['nomgeo'],
                    ]
                );

                // 3) Localidades por municipio
                $locRows = Http::retry(3, 300)
                    ->get("{$this->base}/localidades/{$munRow['cvegeo']}")
                    ->json('datos') ?? [];

                foreach ($locRows as $locRow) {
                    $urban = isset($locRow['ambito']) ? ($locRow['ambito'] === 'U') : null;

                    Locality::updateOrCreate(
                        ['municipality_id' => $munModel->id, 'cve_loc' => $locRow['cve_loc']],
                        [
                            'cve_geo'    => ($munRow['cvegeo'] ?? ($stateRow['cve_ent'] . $munRow['cve_mun'])) . $locRow['cve_loc'],
                            'name'       => $locRow['nomgeo'] ?? '',
                            'urban_area' => $urban,
                            'lat'        => is_numeric($locRow['latitud']  ?? null) ? $locRow['latitud']  : null,
                            'lng'        => is_numeric($locRow['longitud'] ?? null) ? $locRow['longitud'] : null,
                        ]
                    );
                }

                $this->info("Municipio {$munModel->name}: +" . count($locRows) . " localidades");
            }

            $this->info("Estado {$stateModel->name}: +" . count($munRows) . " municipios");
        }

        $this->info("Import completed");
        return self::SUCCESS;
    }
}
