<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Reportes;

use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;


class ReportesRepository implements ReportesRepositoryInterface
{

    use AuthenticationTrait;

    public function getDataDashboard(Request $request)
    {
        //Muestras que se han sacado por dia
        //Muestras enviadas al sponsor 30 dias hacia atras
        //Muestras en transporte
        //muestras recibidas

        try {

            $muestrasTomadasDiaActual = ReportesComplements::muestrasTomadasDiaActual();
            $muestrasPorEstado = ReportesComplements::getMuestrasForEstados();
            $getTotalMuestrasTomadas = ReportesComplements::getTotalMuestrasTomadas();
            $generoDePacientes = ReportesComplements::getGeneroDePacientes();
            $getEdadPacientes = ReportesComplements::getEdadPacientes();


            $resultadoDashboard = [
                'muestrasTomadasPorDia' => $muestrasTomadasDiaActual,
                'muestrasEnviadasAlsponsor' => [],
                'muestrasPorEstados' => $muestrasPorEstado,
                'totalmuestrastomadas' => $getTotalMuestrasTomadas,
                'generoDePacientes' => $generoDePacientes,
                'edadPacientes' => $getEdadPacientes,
            ];

            return $this->success($resultadoDashboard, count($resultadoDashboard), 'Ok', 200);


        } catch (\Throwable $th) {
            throw $th;
        }

        return 'ok';
    }
}
