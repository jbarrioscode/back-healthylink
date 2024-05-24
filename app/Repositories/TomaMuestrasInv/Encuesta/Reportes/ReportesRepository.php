<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Reportes;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria\RespuestaInformacionHistoriaClinica;
use App\Traits\AuthenticationTrait;
use Carbon\Carbon;
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
            $getMuestrasEnviadasSponsor = ReportesComplements::getMuestrasEnviadasAsponsor();


            $resultadoDashboard = [
                'muestrasTomadasPorDia' => $muestrasTomadasDiaActual,
                'muestrasEnviadasAlsponsor' => $getMuestrasEnviadasSponsor,
                'muestrasPorEstados' => $muestrasPorEstado,
                'totalmuestrastomadas' => $getTotalMuestrasTomadas,
                'generoDePacientes' => $generoDePacientes,
                'edadPacientes' => $getEdadPacientes,
            ];

            return $this->success($resultadoDashboard, count($resultadoDashboard), 'Ok', 200);


        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function getDataForFecha(Request $request, $dateStart, $dateEnd)
    {
        try {

            $fechaInicio = Carbon::parse($dateStart);
            $fechaFin = Carbon::parse($dateEnd);

            $diferenciaDias = $fechaInicio->diffInDays($fechaFin);


            if($diferenciaDias > 31){
                return $this->error('El intervalo de fecha no puede ser mayor a 31 dias',204,[]);
            }

            $dataPrincipal = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
                ->leftJoin('minv_detalle_encuestas', 'minv_detalle_encuestas.minv_formulario_id', '=', 'minv_formulario_muestras.id')
                ->select(
                    'minv_formulario_muestras.id',
                    'minv_formulario_muestras.code_paciente',
                    'pacientes.ciudad_residencia',
                    'pacientes.departamento_residencia',
                    'pacientes.fecha_nacimiento',
                    'pacientes.grupo_sanguineo',
                    'pacientes.pais_residencia',
                    'pacientes.sexo',
                    'minv_detalle_encuestas.*'
                )
                ->whereBetween('minv_formulario_muestras.created_at', [$dateStart, $dateEnd])
                ->get()
                ->each(function ($item) {
                    $item->makeHidden('deleted_at','updated_at','created_at');
                });
            $formularioIds = [];
            foreach ($dataPrincipal as $dat){
                $formularioIds[]=$dat->minv_formulario_id;
            }


            $dataComplementaria = RespuestaInformacionHistoriaClinica::leftJoin('minv_formulario_muestras', 'minv_formulario_muestras.id', '=', 'minv_respuesta_informacion_historia_clinicas.minv_formulario_id')
                ->leftJoin('minv_pregunta_historia_clinicas', 'minv_pregunta_historia_clinicas.id', '=', 'minv_respuesta_informacion_historia_clinicas.pregunta_id')
                ->whereIn('minv_formulario_muestras.id', $formularioIds)
                ->select(
                    'minv_formulario_muestras.code_paciente',
                    'minv_pregunta_historia_clinicas.pregunta',
                    'minv_respuesta_informacion_historia_clinicas.fecha',
                    'minv_respuesta_informacion_historia_clinicas.respuesta',
                    'minv_respuesta_informacion_historia_clinicas.unidad',
                    'minv_respuesta_informacion_historia_clinicas.tipo_imagen',
                    'minv_respuesta_informacion_historia_clinicas.observacion',
                    'minv_respuesta_informacion_historia_clinicas.valor'
                )
                ->orderBy('minv_formulario_muestras.code_paciente')
                ->get();

            return $this->success(['survey'=>$dataPrincipal,'dataComplementaria'=>$dataComplementaria], count($dataPrincipal), 'Ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
