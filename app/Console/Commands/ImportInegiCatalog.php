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
    protected $description = 'Import ONLY SLP (Ciudad Valles) from INEGI';

    private string $base = 'https://gaia.inegi.org.mx/wscatgeo/v2';

    // Filtros fijos
    private const SLP_CVE_ENT = '24';
    private const VALLES_CVE_MUN = '015';
    private const VALLES_NAME = 'ciudad valles';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            DB::statement('TRUNCATE localities RESTART IDENTITY CASCADE');
            DB::statement('TRUNCATE municipalities RESTART IDENTITY CASCADE');
            DB::statement('TRUNCATE states RESTART IDENTITY CASCADE');
        }

        // 1) Estados
        $stateRows = Http::retry(3, 300)->get("{$this->base}/mgee/")->json('datos') ?? [];

        // Filtrar únicamente SLP (24)
        $stateRows = array_values(array_filter($stateRows, function ($s) {
            return ($s['cve_ent'] ?? null) === self::SLP_CVE_ENT;
        }));

        foreach ($stateRows as $stateRow) {
            $stateModel = State::updateOrCreate(
                ['cve_ent' => $stateRow['cve_ent']],
                [
                    'name'         => $stateRow['nomgeo'] ?? $stateRow['cve_ent'],
                    'abbreviation' => $stateRow['nom_abrev'] ?? null,
                ]
            );

            // 2) Municipios solo del estado 24
            $munRows = Http::retry(3, 300)->get("{$this->base}/mgem/{$stateRow['cve_ent']}")->json('datos') ?? [];

            // Filtrar únicamente Ciudad Valles (cve_mun 015 o por nombre exacto)
            $munRows = array_values(array_filter($munRows, function ($m) {
                $byCode = ($m['cve_mun'] ?? null) === self::VALLES_CVE_MUN;
                $byName = isset($m['nomgeo']) && mb_strtolower($m['nomgeo']) === self::VALLES_NAME;
                return $byCode || $byName;
            }));

            foreach ($munRows as $munRow) {
                $munModel = Municipality::updateOrCreate(
                    ['state_id' => $stateModel->id, 'cve_mun' => $munRow['cve_mun']],
                    [
                        // INEGI: 'cvegeo' (5 dígitos: 24 + 015 = 24015)
                        'cve_geo' => $munRow['cvegeo'],
                        'name'    => $munRow['nomgeo'],
                    ]
                );

                // 3) Localidades del municipio filtrado
                $locRows = Http::retry(3, 300)->get("{$this->base}/localidades/{$munRow['cvegeo']}")->json('datos') ?? [];

                foreach ($locRows as $locRow) {
                    $urban = isset($locRow['ambito']) ? ($locRow['ambito'] === 'U') : null;

                    Locality::updateOrCreate(
                        ['municipality_id' => $munModel->id, 'cve_loc' => $locRow['cve_loc']],
                        [
                            // cve_geo localidad: cvegeo municipal (5) + cve_loc (4) => 9 dígitos
                            'cve_geo'    => ($munRow['cvegeo'] ?? ($stateRow['cve_ent'] . $munRow['cve_mun'])) . $locRow['cve_loc'],
                            'name'       => $locRow['nomgeo'] ?? '',
                            'urban_area' => $urban,
                            'lat'        => is_numeric($locRow['latitud']  ?? null) ? $locRow['latitud']  : null,
                            'lng'        => is_numeric($locRow['longitud'] ?? null) ? $locRow['longitud'] : null,
                        ]
                    );
                }

                $this->info("Municipio {$munModel->name} ({$munRow['cvegeo']}): +" . count($locRows) . " localidades");
            }

            $this->info("Estado {$stateModel->name}: +" . count($munRows) . " municipio(s) (solo Ciudad Valles)");
        }

        $this->info("Import completed (SLP > Ciudad Valles)");
        return self::SUCCESS;
    }
}
