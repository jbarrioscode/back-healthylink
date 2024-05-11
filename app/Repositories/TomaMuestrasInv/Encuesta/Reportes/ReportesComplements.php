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

        $sedes=[];
        $distintasSedes=[];
        $cantidades_dias=[];

        foreach ($query as $data){
            $sedes[] = $data->nombre;
        }

        $distintasSedes = array_unique($sedes);


        $diaEncontrado=false;
        $diaHoy=Carbon::now();

        $hace7dias = $diaHoy->subDays(8);

        for ($i = 1; $i <= 8; $i++) {

            $diaEncontrado=false;
            $diaSeleccionado= $hace7dias ->addDay();

            $diaSeleccionado=$diaSeleccionado->toDateString();


            foreach ($query as $qr){

                if($diaSeleccionado===$qr->fecha){

                    $diaEncontrado=true;

                    $cantidades_dias[] = [
                        'sede' => $qr->nombre,//"nombre" es el nombre de la sede
                        'fecha' => $diaSeleccionado,
                        'cantidad'=>$qr->cantidad_muestras
                    ];

                }
            }

            if(!$diaEncontrado){
                foreach ($distintasSedes as $sed){

                    $cantidades_dias[] = [
                        'sede' =>$sed,
                        'fecha' => $diaSeleccionado,
                        'cantidad'=>0
                    ];

                }

            }


        }

        return ["cantidades"=>$cantidades_dias,"sedes"=>$distintasSedes];

    }


    public static function getMuestrasForEstados()
    {
        $resultados = EstadosMuestras::leftJoin('minv_log_muestras as mlm', function ($join) {
            $join->on('mlm.minv_estados_muestras_id', '=', 'minv_estados_muestras.id')
                ->leftJoin('minv_formulario_muestras as mfm', 'mfm.id', '=', 'mlm.minv_formulario_id')
                ->where('mfm.created_at', '>', '2024-05-01');
            })
            ->selectRaw('COUNT(mlm.id) as cantidad_muestras, minv_estados_muestras.nombre')
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


}
