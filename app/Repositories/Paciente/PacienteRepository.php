<?php

namespace App\Repositories\Paciente;

use App\Http\Controllers\Api\v1\Encrypt\EncryptEncuestaInvController;
use App\Models\TomaMuestrasInv\Muestras\DetalleEncuesta;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Paciente\ConsentimientoInformadoPaciente;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Models\TomaMuestrasInv\Paciente\RevocacionConsentimientoInformadoPacientes;
use App\Repositories\TomaMuestrasInv\Encuesta\Automatizacion\EnvioCorreosAutomaticosRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\ValidacionesEncuestaInvRepository;
use App\Traits\AuthenticationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PacienteRepository implements PacienteRepositoryInterface
{
    use AuthenticationTrait;

    public function createPatient(Request $request)
    {

        try {
            $rules = [
                'tipo_doc' => 'required|string',
                'numero_documento' => 'required|string|unique:pacientes',
                'primer_nombre' => 'required|string',
                'primer_apellido' => 'required|string',
                'segundo_apellido' => 'required|string',
                'telefono_celular' => 'required|string',
                'fecha_nacimiento' => 'required|string',
                'sexo' => 'required|string',
                'grupo_sanguineo' => 'required|string',
            ];

            $messages = [
                'tipo_doc.required' => 'El nombre es obligatorio.',
                'numero_documento.unique' => 'El numero de documento ya se encuentra registrado.',
                'numero_documento.required' => 'Numero de documento esta vacio.',
                'primer_nombre.required' => 'Primer nombre está vacio.',
                'telefono_celular.required' => 'Telefono celular está vacio.',
                'primer_apellido.required' => 'Primer apellido está vacio.',
                'segundo_apellido.required' => 'Segundo apellido está vacio.',
                'fecha_nacimiento.required' => 'fecha de nacimiento está vacio.',
                'sexo.required' => 'sexo está vacio.',
                'grupo_sanguineo.required' => 'grupo sanguineo está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $paciente = Pacientes::create([
                'tipo_doc' => $request->tipo_doc,
                'numero_documento' => $request->numero_documento,
                'telefono_celular' => $request->telefono_celular,
                'primer_nombre' => EncryptEncuestaInvController::encryptar($request->primer_nombre),
                'segundo_nombre' => EncryptEncuestaInvController::encryptar($request->segundo_nombre),
                'primer_apellido' => EncryptEncuestaInvController::encryptar($request->primer_apellido),
                'segundo_apellido' => EncryptEncuestaInvController::encryptar($request->segundo_apellido),
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'pais_residencia' => $request->pais_residencia,
                'departamento_residencia' => $request->departamento_residencia,
                'ciudad_residencia' => $request->ciudad_residencia,
                'sexo' => $request->sexo,
                'correo_electronico' => $request->correo_electronico,
                'grupo_sanguineo' => $request->grupo_sanguineo
            ]);

            if (!$paciente) return $this->error("Error al registrar paciente", 500, "");

            return $this->success($paciente, 1, 'Paciente registrado correctamente', 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPatient(Request $request, $id)
    {

        try {
            if ($id == 0) {
                $pacientes = Pacientes::all();

            } else {
                $pacientes = Pacientes::where('id', $id)->get();
            }

            foreach ($pacientes as $pac) {


                $pac->primer_nombre = EncryptEncuestaInvController::decrypt($pac->primer_nombre);
                $pac->segundo_nombre = EncryptEncuestaInvController::decrypt($pac->segundo_nombre);
                $pac->primer_apellido = EncryptEncuestaInvController::decrypt($pac->primer_apellido);
                $pac->segundo_apellido = EncryptEncuestaInvController::decrypt($pac->segundo_apellido);

            }

            if (count($pacientes) == 0) return $this->error("No se encontró pacientes", 204, []);

            return $this->success($pacientes, count($pacientes), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function patientInformedConsent(Request $request)
    {
        DB::beginTransaction();

        try {
            $rules = [
                //'tipo_consentimiento_id' => 'required|string',
                'tipo_consentimiento_id' => 'required',
                //'tipo_estudio_id' => 'required|string',
                'tipo_estudio_id' => 'required',
                /*'paciente_id' => 'required|string',*/
                'firma' => 'required|string',
            ];

            $messages = [
                'tipo_consentimiento_id.required' => 'El tipo de consentimiento es obligatorio.',
                'tipo_estudio_id.required' => 'El ID del tipo de estudio está vacio.',
                /*'paciente_id.required' => 'El ID del paciente está vacio.',*/
                'firma.required' => 'Firma está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $patient = Pacientes::all()
                ->where('tipo_doc', '=', $request->tipo_doc)
                ->where('numero_documento', '=', $request->numero_documento)
                ->first();

            $consentimiento = ConsentimientoInformadoPaciente::create([
                'tipo_consentimiento_id' => $request->tipo_consentimiento_id,
                'tipo_estudio_id' => $request->tipo_estudio_id,
                'paciente_id' => $patient->id,
                'firma' => $request->firma,
            ]);

            $date = Carbon::now();
            /*
            EnvioCorreosAutomaticosRepository::envioCorreoConsentimiento(
                EncryptEncuestaInvController::decrypt($patient->primer_nombre).' '.EncryptEncuestaInvController::decrypt($patient->segundo_nombre)
                        . ' '.EncryptEncuestaInvController::decrypt($patient->primer_apellido). ' '.EncryptEncuestaInvController::decrypt($patient->segundo_apellido). ' ',
                $patient->numero_documento,
                $patient->ciudad_residencia,
                $patient->telefono_celular,
                $patient->correo_electronico,
                $request->firma,
                $date->toDateTimeString()
            );
            */

            //---------------------------------------------------

            /*
            $patient = Pacientes::all()
                ->where('tipo_doc', '=', $request->tipo_doc)
                ->where('numero_documento', '=', $request->numero_documento)
                ->first();
            */
            $validacion = ValidacionesEncuestaInvRepository::validarCrearEncuesta($request, $patient->id);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            do {
                $code_paciente = strtoupper(Str::random(4, 'abcdefghijklmnopqrstuvwxyz0123456789'));
            } while (count(FormularioMuestra::where('code_paciente', '=', $code_paciente)->get()) === 1);


            $formulario = FormularioMuestra::create([
                'paciente_id' => $patient->id,
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
                    'nacionalidad_pais_abuelo_materno' => $det['nacionalidad_pais_abuelo_materno'],
                    'nacionalidad_ciudad_abuelo_materno' => $det['nacionalidad_ciudad_abuelo_materno'],
                    'nacionalidad_pais_abuela_materno' => $det['nacionalidad_pais_abuela_materno'],
                    'nacionalidad_ciudad_abuela_materno' => $det['nacionalidad_ciudad_abuela_materno'],
                    'nacionalidad_pais_abuelo_paterno' => $det['nacionalidad_pais_abuelo_paterno'],
                    'nacionalidad_ciudad_abuelo_paterno' => $det['nacionalidad_ciudad_abuelo_paterno'],
                    'nacionalidad_pais_abuela_paterno' => $det['nacionalidad_pais_abuela_paterno'],
                    'nacionalidad_ciudad_abuela_paterno' => $det['nacionalidad_ciudad_abuela_paterno'],
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
            $formulario->code = '-'.$code_paciente.'-'.$request->sedes_toma_muestras_id.'-'.$request->user_created_id;

            EnvioCorreosAutomaticosRepository::envioCorreoConsentimiento(
                EncryptEncuestaInvController::decrypt($patient->primer_nombre).' '.EncryptEncuestaInvController::decrypt($patient->segundo_nombre)
                . ' '.EncryptEncuestaInvController::decrypt($patient->primer_apellido). ' '.EncryptEncuestaInvController::decrypt($patient->segundo_apellido). ' ',
                $patient->numero_documento,
                $patient->ciudad_residencia,
                $patient->telefono_celular,
                $patient->correo_electronico,
                $request->firma,
                $date->toDateTimeString()
            );

            return $this->success($formulario, 1, 'Formulario registrado', 201);


            //return $this->success($consentimiento, 1, 'Consentimiento registrado correctamente', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function getpatientInformedConsent(Request $request,$paciente_id)
    {

        try {

            $consentimiento = ConsentimientoInformadoPaciente::where('paciente_id', $paciente_id)->get();

            if (count($consentimiento) == 0) return $this->error("No se encontró ningun consentimiento", 204, []);

            return $this->success($consentimiento, count($consentimiento), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }

    }


    public function revokeInformedConsent(Request $request)
    {
        try {
            $rules = [
                'tipo_consentimiento_id' => 'required|string',
                'tipo_estudio_id' => 'required|string',
                'paciente_id' => 'required|string',
                'firma' => 'required|string',
            ];

            $messages = [
                'tipo_consentimiento_id.required' => 'El tipo de consentimiento es obligatorio.',
                'tipo_estudio_id.required' => 'El ID del tipo de estudio está vacio.',
                'paciente_id.required' => 'El ID del paciente está vacio.',
                'firma.required' => 'Firma está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $consentimiento = RevocacionConsentimientoInformadoPacientes::create([
                'tipo_consentimiento_id' => $request->tipo_consentimiento_id,
                'tipo_estudio_id' => $request->tipo_estudio_id,
                'paciente_id' => $request->paciente_id,
                'firma' => $request->firma,
            ]);

            FormularioMuestra::where('paciente_id', $request->paciente_id)->delete();

            return $this->success($consentimiento, 1, 'Revocacion consentimiento registrado correctamente', 201);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
