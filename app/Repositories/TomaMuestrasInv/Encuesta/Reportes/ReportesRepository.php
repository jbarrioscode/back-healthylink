<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\Reportes;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria\RespuestaInformacionHistoriaClinica;
use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Models\UserForSedes;
use App\Traits\AuthenticationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
            //return ReportesComplements::muestrasTomadasDiaActual();
            $muestrasTomadasDiaActual = ReportesComplements::muestrasTomadasDiaActual();
            $muestrasPorEstado = ReportesComplements::getMuestrasForEstados();
            $getTotalMuestrasTomadas = ReportesComplements::getTotalMuestrasTomadas();
            $getMuestrasPendientesEcrf = ReportesComplements::getMuestrasPendientesEcrf();
            $generoDePacientes = ReportesComplements::getGeneroDePacientes();
            $getEdadPacientes = ReportesComplements::getEdadPacientes();
            $getMuestrasEnviadasSponsor = ReportesComplements::getMuestrasEnviadasAsponsor();


            $resultadoDashboard = [
                'muestrasTomadasPorDia' => $muestrasTomadasDiaActual,
                'muestrasEnviadasAlsponsor' => $getMuestrasEnviadasSponsor,
                'muestrasPorEstados' => $muestrasPorEstado,
                'pendientesecrf' => $getMuestrasPendientesEcrf,
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
            /*
            set_time_limit(360);



            $permisoDescarga=UserForSedes::where('user_id',\auth()->user()->id)->get();

            if(count($permisoDescarga) == 0) return $this->error('No tiene ninguna sede asignada para ver este reporte', 204, []);

            $sedes_permiso=[];

            foreach ($permisoDescarga as $perm){

                if(!$perm->allSedes){
                    $sedes_permiso[]=$perm->sedes_toma_muestras_id;
                }else{

                    $sedes_permiso = SedesTomaMuestra::all()->pluck('id')->toArray();

                }

            }

            $fecha = Carbon::createFromFormat('Y-m-d', $dateEnd);

            $dateEnd = $fecha->addHour(5);


            $dataPrincipal = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
                ->leftJoin('minv_detalle_encuestas', 'minv_detalle_encuestas.minv_formulario_id', '=', 'minv_formulario_muestras.id')
                ->leftJoin('sedes_toma_muestras', 'sedes_toma_muestras.id', '=', 'minv_formulario_muestras.sedes_toma_muestras_id')
                ->select(
                    'minv_formulario_muestras.id',
                    'minv_formulario_muestras.created_at as fecha',
                    'minv_formulario_muestras.code_paciente',
                    'sedes_toma_muestras.nombre as sede',
                    'pacientes.ciudad_residencia',
                    'pacientes.departamento_residencia',
                    'pacientes.fecha_nacimiento',
                    'pacientes.grupo_sanguineo',
                    'pacientes.pais_residencia',
                    'pacientes.sexo',
                    'minv_detalle_encuestas.*'
                )
                ->whereBetween('minv_formulario_muestras.created_at', [$dateStart, $dateEnd])
                ->whereIn('minv_formulario_muestras.sedes_toma_muestras_id', $sedes_permiso)
                ->get()
                ->each(function ($item) {
                    $item->makeHidden('deleted_at', 'updated_at', 'created_at');
                });



            $formularioIds = $dataPrincipal->pluck('id')->toArray();

            $dataComplementaria = RespuestaInformacionHistoriaClinica::leftJoin('minv_formulario_muestras', 'minv_formulario_muestras.id', '=', 'minv_respuesta_informacion_historia_clinicas.minv_formulario_id')
                ->leftJoin('minv_pregunta_historia_clinicas', 'minv_pregunta_historia_clinicas.id', '=', 'minv_respuesta_informacion_historia_clinicas.pregunta_id')
                ->whereIn('minv_formulario_muestras.id', $formularioIds)
                ->select(
                    'minv_formulario_muestras.code_paciente',
                    'minv_pregunta_historia_clinicas.pregunta',
                    'minv_respuesta_informacion_historia_clinicas.respuesta',
                    'minv_respuesta_informacion_historia_clinicas.valor',
                    'minv_respuesta_informacion_historia_clinicas.fecha',
                    'minv_respuesta_informacion_historia_clinicas.pregunta_id',
                    'minv_respuesta_informacion_historia_clinicas.tipo_imagen'
                )
                ->orderBy('minv_formulario_muestras.code_paciente')
                ->get();



            $combinedData = [];

            foreach ($dataPrincipal as $principalItem) {
                $combinedItem = $principalItem->toArray();
                $codePaciente = $principalItem->code_paciente;

                foreach ($dataComplementaria as $complementario) {
                    if ($complementario->code_paciente === $codePaciente) {
                        if ($complementario->pregunta_id == 6) {
                            if (!is_null($complementario->fecha)) {

                                if($complementario->tipo_imagen == 'N/A'){
                                    $combinedItem[$complementario->pregunta] = 'N/A';
                                }else{
                                    $combinedItem[$complementario->pregunta] = $complementario->fecha . ' ' . $complementario->tipo_imagen .' '. $complementario->respuesta;
                                }

                            } else {
                                $combinedItem[$complementario->pregunta] = $complementario->respuesta;
                            }
                        } elseif (in_array($complementario->pregunta_id, [1, 7, 8])) {
                            $combinedItem[$complementario->pregunta] = $complementario->respuesta;
                        } elseif ($complementario->pregunta_id == 2) {

                            if (!isset($combinedItem['Antecedentes Farmacológicos'])) {
                                $combinedItem['Antecedentes Farmacológicos'] = '';
                            }

                            if (strpos($complementario->respuesta, 'N/A') !== false){
                                $combinedItem['Antecedentes Farmacológicos'] .= "N/A";
                            }else{
                                $combinedItem['Antecedentes Farmacológicos'] .= "({$complementario->fecha} {$complementario->respuesta} {$complementario->valor}) ";

                            }

                        } elseif ($complementario->pregunta_id == 9) {

                            if (!isset($combinedItem['Antecedentes patologicos (CIE10)'])) {
                                $combinedItem['Antecedentes patologicos (CIE10)'] = '';
                            }

                            $cie10part = explode('-', $complementario->respuesta);

                            if(!isset($cie10part[0])){
                                $cie10part=$complementario->respuesta;
                            }else{
                                $cie10part=$cie10part[0];
                            }

                            if (strpos($complementario->respuesta, 'N/A') !== false){
                                $combinedItem['Antecedentes patologicos (CIE10)'] .= "N/A";
                            }else{
                                $combinedItem['Antecedentes patologicos (CIE10)'] .= "{$cie10part};";

                            }

                        } elseif ($complementario->pregunta_id == 10) {

                            if (!isset($combinedItem['Otros laboratorios'])) {
                                $combinedItem['Otros laboratorios'] = '';
                            }

                            if (strpos($complementario->respuesta, 'N/A') !== false){
                                $combinedItem['Otros laboratorios'] .= "N/A";
                            }else{
                                $combinedItem['Otros laboratorios'] .= "({$complementario->fecha} {$complementario->respuesta} {$complementario->valor}) ";

                            }


                        } else {
                            //LABORATORIOS

                            $partsLab = explode(' ', $complementario->valor);

                            $key = $complementario->pregunta . ' - ' . $complementario->respuesta;

                            if (strpos($complementario->valor, 'N/A') !== false || $partsLab[0] == '0') {
                                $combinedItem[$key] = 'N/A';
                            } else {
                                $combinedItem[$key] = $complementario->fecha . ' ' . $complementario->valor;
                            }


                        }
                    }
                }

                $combinedData[] = $combinedItem;
            }

            return $this->success(['survey' => $combinedData,'dataComplementaria' => []], count($dataPrincipal), 'Ok', 200);


            ===========================================

            VERSION OPTIMIZADA

            ===========================================
            */

            set_time_limit(360);
            ini_set('memory_limit', '600M');



            $permisoDescarga = UserForSedes::where('user_id', \auth()->user()->id)->get(); //\auth()->user()->id

            if ($permisoDescarga->isEmpty()) {
                return $this->error('No tiene ninguna sede asignada para ver este reporte', 204, []);
            }

            $sedes_permiso = $permisoDescarga->flatMap(function ($perm) {
                return $perm->allSedes ? SedesTomaMuestra::all()->pluck('id') : [$perm->sedes_toma_muestras_id];
            })->unique()->toArray();

            if($dateStart==0 && $dateEnd==0){

                $dataPrincipal = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
                    ->leftJoin('minv_detalle_encuestas', 'minv_detalle_encuestas.minv_formulario_id', '=', 'minv_formulario_muestras.id')
                    ->leftJoin('sedes_toma_muestras', 'sedes_toma_muestras.id', '=', 'minv_formulario_muestras.sedes_toma_muestras_id')
                    ->select(
                        'minv_formulario_muestras.id',
                        'minv_formulario_muestras.created_at as fecha',
                        'minv_formulario_muestras.code_paciente',
                        'sedes_toma_muestras.nombre as sede',
                        'pacientes.ciudad_residencia',
                        'pacientes.departamento_residencia',
                        'pacientes.fecha_nacimiento',
                        'pacientes.grupo_sanguineo',
                        'pacientes.pais_residencia',
                        'pacientes.sexo',
                        'minv_detalle_encuestas.*'
                    )->whereIn('minv_formulario_muestras.sedes_toma_muestras_id', $sedes_permiso)
                    ->get()
                    ->each(function ($item) {
                        $item->fecha = Carbon::parse($item->fecha)->subHours(5)->format('Y-m-d H:i:s');
                        $item->makeHidden(['deleted_at', 'updated_at', 'created_at']);
                    });

            }else{
                $fechaEnd = Carbon::createFromFormat('Y-m-d', $dateEnd)->setTime(23, 59, 59);

                $dataPrincipal = FormularioMuestra::leftJoin('pacientes', 'pacientes.id', '=', 'minv_formulario_muestras.paciente_id')
                    ->leftJoin('minv_detalle_encuestas', 'minv_detalle_encuestas.minv_formulario_id', '=', 'minv_formulario_muestras.id')
                    ->leftJoin('sedes_toma_muestras', 'sedes_toma_muestras.id', '=', 'minv_formulario_muestras.sedes_toma_muestras_id')
                    ->select(
                        'minv_formulario_muestras.id',
                        'minv_formulario_muestras.created_at as fecha',
                        'minv_formulario_muestras.code_paciente',
                        'sedes_toma_muestras.nombre as sede',
                        'pacientes.ciudad_residencia',
                        'pacientes.departamento_residencia',
                        'pacientes.fecha_nacimiento',
                        'pacientes.grupo_sanguineo',
                        'pacientes.pais_residencia',
                        'pacientes.sexo',
                        'minv_detalle_encuestas.*'
                    )
                    ->whereBetween('minv_formulario_muestras.created_at', [$dateStart, $fechaEnd])
                    ->whereIn('minv_formulario_muestras.sedes_toma_muestras_id', $sedes_permiso)
                    ->get()
                    ->each(function ($item) {
                        $item->fecha = Carbon::parse($item->fecha)->subHours(5)->format('Y-m-d H:i:s');;
                        $item->makeHidden(['deleted_at', 'updated_at', 'created_at']);
                    });
            }


            $formularioIds = $dataPrincipal->pluck('minv_formulario_id');

            $dataComplementaria = RespuestaInformacionHistoriaClinica::leftJoin('minv_formulario_muestras', 'minv_formulario_muestras.id', '=', 'minv_respuesta_informacion_historia_clinicas.minv_formulario_id')
                ->leftJoin('minv_pregunta_historia_clinicas', 'minv_pregunta_historia_clinicas.id', '=', 'minv_respuesta_informacion_historia_clinicas.pregunta_id')
                ->whereIn('minv_formulario_muestras.id', $formularioIds)
                ->select(
                    'minv_formulario_muestras.code_paciente',
                    'minv_pregunta_historia_clinicas.pregunta',
                    'minv_respuesta_informacion_historia_clinicas.respuesta',
                    'minv_respuesta_informacion_historia_clinicas.valor',
                    'minv_respuesta_informacion_historia_clinicas.fecha',
                    'minv_respuesta_informacion_historia_clinicas.pregunta_id',
                    'minv_respuesta_informacion_historia_clinicas.tipo_imagen'
                )
                ->orderBy('minv_formulario_muestras.code_paciente')
                ->get()
                ->groupBy('code_paciente');

            $combinedData = $dataPrincipal->map(function ($principalItem) use ($dataComplementaria) {
                $combinedItem = $principalItem->toArray();
                $codePaciente = $principalItem->code_paciente;
                $complementarios = $dataComplementaria->get($codePaciente, collect());

                foreach ($complementarios as $complementario) {
                    $pregunta = $complementario->pregunta;
                    $respuesta = $complementario->respuesta;
                    $valor = $complementario->valor;
                    $fecha = $complementario->fecha;
                    $tipoImagen = $complementario->tipo_imagen;

                    switch ($complementario->pregunta_id) {
                        case 6:
                            $combinedItem[$pregunta] = $fecha ? ($tipoImagen == 'N/A' ? 'N/A' : "{$fecha} {$tipoImagen} {$respuesta}") : $respuesta;
                            break;
                        case 1:
                        case 7:
                        case 8:
                            $combinedItem[$pregunta] = $respuesta;
                            break;
                        case 2:
                            $combinedItem['Antecedentes Farmacológicos'] = ($combinedItem['Antecedentes Farmacológicos'] ?? '') . (strpos($respuesta, 'N/A') !== false ? 'N/A' : "({$fecha} {$respuesta} {$valor}) ");
                            break;
                        case 9:
                            $cie10part = explode('-', $respuesta)[0] ?? $respuesta;
                            $combinedItem['Antecedentes patologicos (CIE10)'] = ($combinedItem['Antecedentes patologicos (CIE10)'] ?? '') . (strpos($respuesta, 'N/A') !== false ? 'N/A' : "{$cie10part};");
                            break;
                        case 10:
                            $combinedItem['Otros laboratorios'] = ($combinedItem['Otros laboratorios'] ?? '') . (strpos($respuesta, 'N/A') !== false ? 'N/A' : "({$fecha} {$respuesta} {$valor}) ");
                            break;
                        default:
                            $key = "{$pregunta} - {$respuesta}";
                            $combinedItem[$key] = strpos($valor, 'N/A') !== false || explode(' ', $valor)[0] == '0' ? 'N/A' : "{$fecha} {$valor}";
                            break;
                    }
                }

                return $combinedItem;
            });

            return $this->success(['survey' => $combinedData, 'dataComplementaria' => []], $dataPrincipal->count(), 'Ok', 200);


        } catch (\Exception $e) {
            Log::error( $e->getMessage());
            return $this->error( $e->getMessage(),500,[]);
            //throw $th;
        }
    }


}
