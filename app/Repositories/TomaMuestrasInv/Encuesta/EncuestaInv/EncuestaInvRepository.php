<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use App\Models\TomaMuestrasInv\Muestras\AsignacionMuestraUbicacion;
use App\Models\TomaMuestrasInv\Muestras\DetalleEncuesta;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\Lote;
use App\Models\TomaMuestrasInv\Muestras\LoteMuestras;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class EncuestaInvRepository implements EncuestaInvRepositoryInterface
{
    use AuthenticationTrait;

    public function crearEncuesta(Request $request)
    {

        DB::beginTransaction();

        try {


            //SE CREA EL FORMULARIO Y LUEGO SE GUARDA LOS DETALLES

            $validacion = ValidacionesEncuestaInvRepository::validarCrearEncuesta($request);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            do {
                $code_paciente = strtoupper(Str::random(8, 'abcdefghijklmnopqrstuvwxyz0123456789'));
            } while (count(FormularioMuestra::where('code_paciente', '=', $code_paciente)->get()) === 1);


            $formulario = FormularioMuestra::create([
                'paciente_id' => $request->paciente_id,
                'user_created_id' => $request->user_created_id,
                'code_paciente' => $code_paciente,
                'tipo_estudio_id' => $request->tipo_estudio_id,
                'sedes_toma_muestras_id' => $request->sedes_toma_muestras_id,
            ]);

            foreach ($request->detalle as $det) {

                $detalle = DetalleEncuesta::create([
                    'minv_formulario_id' => $formulario->id,
                    'altura' => $det['altura'],
                    'peso' => $det['peso'],
                    'etnia' => $det['etnia'],
                    'pais_nacimiento' => $det['pais_nacimiento'],
                    'ciudad_nacimiento' => $det['ciudad_nacimiento'],
                    'nacionalidad_abuelo_materno' => $det['nacionalidad_abuelo_materno'],
                    'nacionalidad_abuela_materno' => $det['nacionalidad_abuela_materno'],
                    'nacionalidad_abuelo_paterno' => $det['nacionalidad_abuelo_paterno'],
                    'nacionalidad_abuela_paterno' => $det['nacionalidad_abuela_paterno'],
                    'nacionalidad_paciente' => $det['nacionalidad_paciente'],
                    'es_fumador' => $det['es_fumador'],
                    'presion_arterial' => $det['presion_arterial'],
                    'medicamento_para_presion_arterial' => $det['medicamento_para_presion_arterial'],
                    'altos_niveles_colesterol' => $det['altos_niveles_colesterol'],
                    'frecuencia_consumo_bebidas_alcoholicas' => $det['frecuencia_consumo_bebidas_alcoholicas'],
                    'afeccion_o_enfermededad_cronica__madre' => $det['afeccion_o_enfermededad_cronica__madre'],
                    'cual_afeccion_o_enfermededad_cronica__madre' => $det['cual_afeccion_o_enfermededad_cronica__madre'],
                    'afeccion_o_enfermededad_cronica__padre' => $det['afeccion_o_enfermededad_cronica__padre'],
                    'cual_afeccion_o_enfermededad_cronica__padre' => $det['cual_afeccion_o_enfermededad_cronica__padre'],
                    'afeccion_o_enfermededad_cronica__hermanos' => $det['afeccion_o_enfermededad_cronica__hermanos'],
                    'cual_afeccion_o_enfermededad_cronica__hermanos' => $det['cual_afeccion_o_enfermededad_cronica__hermanos'],
                    'enfermedades_cronicas' => $det['enfermedades_cronicas'],
                    'enfermedades_pulmonares' => $det['enfermedades_pulmonares'],
                    'enfermedades_endocrinas_metabolicas' => $det['enfermedades_endocrinas_metabolicas'],
                    'enfermedades_digestivas' => $det['enfermedades_digestivas'],
                    'enfermedades_renales' => $det['enfermedades_renales'],
                    'enfermedades_neurologicas' => $det['enfermedades_neurologicas'],
                    'enfermedades_dermatologicas' => $det['enfermedades_dermatologicas'],
                    'enfermedades_reumaticas' => $det['enfermedades_reumaticas'],
                    'diagnosticado_cancer_ultimos_cinco_anos' => $det['diagnosticado_cancer_ultimos_cinco_anos'],
                    'cancer_diagnosticado' => $det['cancer_diagnosticado'],
                    'afecciones_diagnosticadas' => $det['afecciones_diagnosticadas'],
                    'analisis_sangre_ultimos_seis_meses' => $det['analisis_sangre_ultimos_seis_meses'],
                    'prueba_positiva_covid_19' => $det['prueba_positiva_covid_19'],
                    'vacunacion_covid_19' => $det['vacunacion_covid_19'],
                    'tipo_vacuna_recibida' => $det['tipo_vacuna_recibida'],
                    'cantidad_dosis_vacunacion_recibida' => $det['cantidad_dosis_vacunacion_recibida'],
                    'sintomas_tenidos_por_covid' => $det['sintomas_tenidos_por_covid'],
                    'hospitalizado_por_covid_19' => $det['hospitalizado_por_covid_19'],
                    'tiempo_recuperacion_covid_19' => $det['tiempo_recuperacion_covid_19'],
                    'sintomas_q_persisten_por_covid_19' => $det['sintomas_q_persisten_por_covid_19'],

                ]);

            }

            LogMuestras::create([
                'minv_formulario_id' => $formulario->id,
                'user_id_executed' => $request->user_created_id,
                'minv_estados_muestras_id' => 1,
            ]);

            DB::commit();
            $formulario->detalle = $detalle;

            return $this->success($formulario, 1, 'Formulario registrado', 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            throw $th;
        }
    }

    public function crearAsignacionAutomaticaAlote(Request $request)
    {
        DB::beginTransaction();

        try {

            $validacion = ValidacionesEncuestaInvRepository::validarAsignarMuestraALote($request->muestras);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            $ultimoID = null;

            $ultimoRegistro = Lote::latest()->first();

            if ($ultimoRegistro) {
                $ultimoID = $ultimoRegistro->id;
            } else {
                $ultimoID = 0;
            }

            $lote = Lote::create([
                'code_lote' => 'LOT-' . ($ultimoID + 1),
            ]);
            $idErrorMuestra = 0;
            foreach ($request->muestras as $mu) {
                $idErrorMuestra = $mu['muestra_id'];
                $detalleLote[] = LoteMuestras::create([
                    'minv_formulario_muestras_id' => $mu['muestra_id'],
                    'lote_id' => $lote->id,
                ]);

                LogMuestras::create([
                    'minv_formulario_id' => $mu['muestra_id'],
                    'user_id_executed' => $request->user_id,
                    'minv_estados_muestras_id' => 2,
                ]);
            }

            $lote->detalleLote = $detalleLote;

            DB::commit();

            return $this->success($lote, 1, 'Lote registrado correctamente', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error con el ID de la muestra: ' . $idErrorMuestra, 204, []);
            throw $th;
        }
    }

    public function lotesEnTrasporte(Request $request)
    {
        DB::beginTransaction();

        try {

            $rules = [
                'code_lote' => 'required|string',
                'user_id_executed' => 'required',
            ];

            $messages = [
                'code_lote.required' => 'code_lote está vacio.',
                'user_id_executed.required' => 'ID usuario está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $muestras = LoteMuestras::select('lote_muestras.minv_formulario_muestras_id')
                ->join('lotes', 'lotes.id', '=', 'lote_muestras.lote_id')
                ->where('lotes.code_lote', $request->code_lote)
                ->get();

            $log=[];
            foreach ($muestras as $mu) {

                $log[]=LogMuestras::create([
                    'minv_formulario_id' => $mu->minv_formulario_muestras_id,
                    'user_id_executed' => $request->user_id_executed,
                    'minv_estados_muestras_id' => 3,
                ]);

            }

            DB::commit();

            return $this->success($log, 1, 'Muestras en trasporte', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }
    }

    public function muestrasEntregadasBioBanco(Request $request)
    {

        DB::beginTransaction();

        try {

            $rules = [
                'code_lote' => 'required|string',
                'user_id_executed' => 'required',
            ];

            $messages = [
                'code_lote.required' => 'code_lote está vacio.',
                'user_id_executed.required' => 'ID usuario está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $muestras = LoteMuestras::select('lote_muestras.minv_formulario_muestras_id')
                ->join('lotes', 'lotes.id', '=', 'lote_muestras.lote_id')
                ->where('lotes.code_lote', $request->code_lote)
                ->get();

            $log=[];
            foreach ($muestras as $mu) {

                $log[]=LogMuestras::create([
                    'minv_formulario_id' => $mu->minv_formulario_muestras_id,
                    'user_id_executed' => $request->user_id_executed,
                    'minv_estados_muestras_id' => 4,
                ]);

            }

            DB::commit();

            return $this->success($log, 1, 'Muestras recibidas en el centro de custodio', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }

    }

    public function muestrasAsignadasAnevera(Request $request)
    {

        try {

            $rules = [
                'code_paciente' => 'required|string',
                'user_id' => 'required',
                'ubicacion_estantes_id' => 'required',
            ];

            $messages = [
                'code_paciente.required' => 'Codigo de paciente está vacio.',
                'user_id.required' => 'ID usuario está vacio.',
                'ubicacion_estantes_id.required' => 'ID de la nevera o estante se encuentra vacia.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $formulario=FormularioMuestra::where('code_paciente',$request->code_paciente)->get();

            $encuesta_id=0;

            foreach ($formulario as $form){
                $encuesta_id=$form->id;
            }

            if($encuesta_id===0) return $this->error('No existe estudio con ese codigo de paciente', 422, []);


            $asignacion=AsignacionMuestraUbicacion::create([
                'minv_formulario_muestras_id' => $encuesta_id,
                'user_id_located' => $request->user_id,
                'ubicacion_estantes_id' => $request->ubicacion_estantes_id,
            ]);

           LogMuestras::create([
                'minv_formulario_id' => $encuesta_id,
                'user_id_executed' => $request->user_id,
                'minv_estados_muestras_id' => 5,
            ]);

            DB::commit();

            return $this->success($asignacion, 1, 'Asignacion realizada correctamente', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }

    }


}


