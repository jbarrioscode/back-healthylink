<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Reportes;

use App\Models\TomaMuestrasInv\Muestras\EstadosMuestras;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportesComplements
{

    public static function muestrasTomadasDiaActual()
    {
        $fechaHace7Dias = Carbon::now()->subDays(7)->toDateString();;


        $query = SedesTomaMuestra::leftJoin('minv_formulario_muestras', function ($join) use ($fechaHace7Dias) {
            $join->on('sedes_toma_muestras.id', '=', 'minv_formulario_muestras.sedes_toma_muestras_id')
                ->whereDate('sedes_toma_muestras.created_at', '<', $fechaHace7Dias);
        })
            ->selectRaw('DATE(minv_formulario_muestras.created_at) as fecha, sedes_toma_muestras.nombre, COUNT(minv_formulario_muestras.id) as cantidad_muestras')
            ->groupBy(DB::raw('DATE(minv_formulario_muestras.created_at)'), 'sedes_toma_muestras.nombre')
            ->get();

        $sedes = [];
        $distintasSedes = [];
        $cantidades_dias = [];

        foreach ($query as $data) {
            $sedes[] = $data->nombre;
        }

        $distintasSedes = array_unique($sedes);


        $diaEncontrado = false;
        $diaHoy = Carbon::now();

        $hace7dias = $diaHoy->subDays(8);

        for ($i = 1; $i <= 8; $i++) {

            $diaEncontrado = false;
            $diaSeleccionado = $hace7dias->addDay();

            $diaSeleccionado = $diaSeleccionado->toDateString();


            foreach ($query as $qr) {

                if ($diaSeleccionado === $qr->fecha) {

                    $diaEncontrado = true;

                    $cantidades_dias[] = [
                        'sede' => $qr->nombre,//"nombre" es el nombre de la sede
                        'fecha' => $diaSeleccionado,
                        'cantidad' => $qr->cantidad_muestras
                    ];

                }
            }

            if (!$diaEncontrado) {
                foreach ($distintasSedes as $sed) {

                    $cantidades_dias[] = [
                        'sede' => $sed,
                        'fecha' => $diaSeleccionado,
                        'cantidad' => 0
                    ];

                }

            }


        }

        return ["cantidades" => $cantidades_dias, "sedes" => $distintasSedes];

    }


    public static function getMuestrasForEstados()
    {
        $fechaHace7Dias = Carbon::now()->subDays(7)->toDateString();;
        $resultados = EstadosMuestras::leftJoin(DB::raw("
        (
           SELECT
		            minv_log_muestras.minv_estados_muestras_id,
		            MAX(minv_log_muestras.id) AS ultimo_id,
		            minv_log_muestras.minv_formulario_id as formulario_id

		        FROM
		            minv_log_muestras

		        left JOIN
		        	minv_formulario_muestras on minv_formulario_muestras.id = minv_log_muestras.minv_formulario_id

		        where
		        	minv_formulario_muestras.created_at > '2024-05-01'


		        GROUP BY
		           minv_log_muestras.minv_formulario_id,minv_log_muestras.minv_estados_muestras_id,minv_log_muestras.id

		         order by (minv_log_muestras.id) DESC

		          limit 1
        ) AS logmuestras
    "), function ($join) {
            $join->on('logmuestras.minv_estados_muestras_id', '=', 'minv_estados_muestras.id');
        })
            ->selectRaw('COUNT(logmuestras.ultimo_id) as cantidad_muestras, minv_estados_muestras.nombre')
            ->groupBy('minv_estados_muestras.nombre', 'minv_estados_muestras.id')
            ->orderByRaw('
        CASE minv_estados_muestras.id
            WHEN 1 THEN 1
            WHEN 2 THEN 2
            WHEN 3 THEN 3
            WHEN 4 THEN 4
            WHEN 7 THEN 5
            WHEN 5 THEN 6
            WHEN 9 THEN 7
            WHEN 8 THEN 8
            WHEN 6 THEN 9
            ELSE 10
        END
    ')
            ->get();

        return $resultados;
    }

    public static function getTotalMuestrasTomadas()
    {
        $fechaHace30Dias = Carbon::now()->subDays(30)->toDateString();;

        $resultado = FormularioMuestra::where('created_at', '>', $fechaHace30Dias)->count('id');

        return $resultado;

    }

    public static function getGeneroDePacientes()
    {
        $fechaHace30Dias = Carbon::now()->subDays(30)->toDateString();;

        $resultado = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
            ->select(DB::raw('COUNT(minv_formulario_muestras.id) as y'), 'pacientes.sexo as name')
            ->where('minv_formulario_muestras.created_at', '>', $fechaHace30Dias)
            ->where(function ($query) {
                $query->where('pacientes.sexo', 'M')
                    ->orWhere('pacientes.sexo', 'F');
            })
            ->groupBy('pacientes.sexo')
            ->get();

        return $resultado;

    }

    public static function getEdadPacientes()
    {
        $fechaHace30Dias = Carbon::now()->subDays(30)->toDateString();;

        $todasEdades = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
            ->selectRaw('DATE_PART(\'year\', AGE(CURRENT_DATE, pacientes.fecha_nacimiento)) AS edad_actual')
            ->where('minv_formulario_muestras.created_at', '>', $fechaHace30Dias)
            ->groupBy('pacientes.fecha_nacimiento')
            ->get();

        $intervalos = [
            ["inicio" => 18, "fin" => 24],
            ["inicio" => 25, "fin" => 30],
        ];

        $conteo_personas = [];

        foreach ($intervalos as $intervalo) {
            $conteo_personas[$intervalo["inicio"] . "-" . $intervalo["fin"]] = 0;
        }

        foreach ($todasEdades as $persona) {
            $edad = (int)$persona["edad_actual"];
            foreach ($intervalos as $intervalo) {
                if ($edad >= $intervalo["inicio"] && $edad <= $intervalo["fin"]) {
                    $conteo_personas[$intervalo["inicio"] . "-" . $intervalo["fin"]]++;
                    break;
                }
            }
        }

        $resultado_final = [];
        foreach ($conteo_personas as $intervalo => $conteo) {
            $resultado_final[] = ["y" => $conteo, "name" => $intervalo];
        }

        return $resultado_final;
    }

    public static function getMuestrasEnviadasAsponsor()
    {
        $resultado= FormularioMuestra::leftJoin('minv_log_muestras', 'minv_log_muestras.minv_formulario_id', '=', 'minv_formulario_muestras.id')
            ->where('minv_log_muestras.minv_estados_muestras_id', 10)
            ->count('minv_formulario_muestras.id');

        return $resultado;
    }
}