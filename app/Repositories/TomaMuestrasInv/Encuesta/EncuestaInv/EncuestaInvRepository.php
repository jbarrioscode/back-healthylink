<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use App\Models\TomaMuestrasInv\Muestras\DetalleEncuesta;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            return $formulario;

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            throw $th;
        }
    }

}
