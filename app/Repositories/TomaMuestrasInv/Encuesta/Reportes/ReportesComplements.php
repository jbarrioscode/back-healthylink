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
        $fechaHace7Dias = Carbon::now()->subDays(7)->toDateString();
        $diaHoy = Carbon::now()->toDateString();


        $sedes = SedesTomaMuestra::select('nombre')->distinct()->pluck('nombre');


        $fechas = [];
        $fechaInicio = Carbon::now()->subDays(7)->subHours(5);
        for ($i = 0; $i <= 7; $i++) {
            $fechas[] = $fechaInicio->copy()->addDays($i)->toDateString();
        }


        $query = SedesTomaMuestra::leftJoin('minv_formulario_muestras', function ($join) use ($fechaHace7Dias) {
            $join->on('sedes_toma_muestras.id', '=', 'minv_formulario_muestras.sedes_toma_muestras_id')
                ->whereDate('minv_formulario_muestras.created_at', '>=', $fechaHace7Dias);
        })
            ->selectRaw('DATE(minv_formulario_muestras.created_at - interval \'5 hours\') as fecha, sedes_toma_muestras.nombre, COUNT(minv_formulario_muestras.id) as cantidad_muestras')
            ->groupBy(DB::raw('DATE(minv_formulario_muestras.created_at - interval \'5 hours\')'), 'sedes_toma_muestras.nombre')
            ->get();


        $cantidades_dias = [];


        foreach ($fechas as $fecha) {
            foreach ($sedes as $sede) {
                $cantidades_dias[$fecha][$sede] = 0;
            }
        }


        foreach ($query as $data) {
            $fecha = $data->fecha;
            $sede = $data->nombre;
            $cantidad = $data->cantidad_muestras;

            if (isset($cantidades_dias[$fecha][$sede])) {
                $cantidades_dias[$fecha][$sede] = $cantidad;
            }
        }


        $resultados = [];
        foreach ($cantidades_dias as $fecha => $sedes) {
            foreach ($sedes as $sede => $cantidad) {
                $resultados[] = [
                    'sede' => $sede,
                    'fecha' => $fecha,
                    'cantidad' => $cantidad,
                ];
            }
        }

        return ["cantidades" => $resultados, "sedes" => $sedes];
    }


    public static function getMuestrasForEstados()
    {
        $fechaHace7Dias = Carbon::now()->subDays(7)->toDateString();

        /*
        $resultados = EstadosMuestras::leftJoin(DB::raw("
        (
           SELECT
			distinct (minv_log_muestras.minv_formulario_id) as formulario_id,
			(
				select mlm.minv_estados_muestras_id
				from minv_log_muestras mlm
				where mlm.minv_formulario_id =minv_log_muestras.minv_formulario_id
				order by mlm.id desc
				limit 1
			)
			as minv_estados_muestras_id

        FROM
            minv_log_muestras
        LEFT JOIN
            minv_formulario_muestras ON minv_formulario_muestras.id = minv_log_muestras.minv_formulario_id
        WHERE
            minv_formulario_muestras.created_at > '".$fechaHace7Dias."'
        GROUP BY
            minv_log_muestras.minv_formulario_id,
            minv_log_muestras.id
        ) AS logmuestras
    "), function ($join) {
            $join->on('logmuestras.minv_estados_muestras_id', '=', 'minv_estados_muestras.id');
        })
            ->selectRaw('COUNT(logmuestras.formulario_id) as cantidad_muestras, minv_estados_muestras.nombre')
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
        */

    $resultados = EstadosMuestras::leftJoin(DB::raw("
    (
        SELECT
            COUNT(id) as formulario_id,
            minv_log_muestras.minv_estados_muestras_id as minv_estados_muestras_id
        FROM minv_log_muestras
        GROUP BY minv_log_muestras.minv_estados_muestras_id
    ) AS logmuestras
    "), function ($join) {
                $join->on('logmuestras.minv_estados_muestras_id', '=', 'minv_estados_muestras.id');
            })
                ->selectRaw('COALESCE(logmuestras.formulario_id, 0) as cantidad_muestras, minv_estados_muestras.nombre')
                ->groupBy('minv_estados_muestras.nombre', 'logmuestras.formulario_id', 'minv_estados_muestras.id')
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

        $resultado = FormularioMuestra::count('id');

        return $resultado;

    }

    public static function getMuestrasPendientesEcrf()
    {

        $resultado = FormularioMuestra::leftJoin('minv_respuesta_informacion_historia_clinicas', 'minv_respuesta_informacion_historia_clinicas.minv_formulario_id', '=', 'minv_formulario_muestras.id')
            ->whereNull('minv_respuesta_informacion_historia_clinicas.id')
            ->orderBy('minv_formulario_muestras.id','asc')
            ->count();

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
            ["inicio" => 18, "fin" => 26],
            ["inicio" => 27, "fin" => 35],
            ["inicio" => 36, "fin" => 44],
            ["inicio" => 45, "fin" => 54],
            ["inicio" => 55, "fin" => 65],
            ["inicio" => 66, "fin" => 75],
            ["inicio" => 76, "fin" => 100],
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
