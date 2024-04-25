<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\LoteMuestras;
use Illuminate\Support\Facades\DB;

class ValidacionesEncuestaInvRepository
{

    public static function validarCrearEncuesta($request,$paciente_id)
    {

        if(count(FormularioMuestra::where('paciente_id','=', $paciente_id)->get())>0){
            return 'Paciente ya se encuentra participando de la encuesta';
        }

        foreach ($request->detalle as $det){

            $validacionDetalles=self::validarCrearDetallesEncuesta($det);

            if($validacionDetalles!==''){
                return $validacionDetalles;
            }
        }

    }
    public static function validarCrearDetallesEncuesta($det)
    {
        $campos_vacios = [];

        if (empty($det['altura'])) {
            $campos_vacios[] = 'altura';
        }
        if (empty($det['peso'])) {
            $campos_vacios[] = 'peso';
        }
        if (empty($det['etnia'])) {
            $campos_vacios[] = 'etnia';
        }
        if (empty($det['pais_nacimiento'])) {
            $campos_vacios[] = 'pais_nacimiento';
        }
        if (empty($det['ciudad_nacimiento'])) {
            $campos_vacios[] = 'ciudad_nacimiento';
        }
        /*
        if (empty($det['nacionalidad_abuelo_materno'])) {
            $campos_vacios[] = 'nacionalidad_abuelo_materno';
        }
        if (empty($det['nacionalidad_abuela_materno'])) {
            $campos_vacios[] = 'nacionalidad_abuela_materno';
        }
        if (empty($det['nacionalidad_abuelo_paterno'])) {
            $campos_vacios[] = 'nacionalidad_abuelo_paterno';
        }
        if (empty($det['nacionalidad_abuela_paterno'])) {
            $campos_vacios[] = 'nacionalidad_abuela_paterno';
        }
        if (empty($det['nacionalidad_paciente'])) {
            $campos_vacios[] = 'nacionalidad_paciente';
        }
        */
        if (empty($det['es_fumador'])) {
            $campos_vacios[] = 'es_fumador';
        }
        if (empty($det['presion_arterial'])) {
            $campos_vacios[] = 'presion_arterial';
        }
        /*
        if (empty($det['medicamento_para_presion_arterial'])) {
            $campos_vacios[] = 'medicamento_para_presion_arterial';
        }
        */
        if (empty($det['altos_niveles_colesterol'])) {
            $campos_vacios[] = 'altos_niveles_colesterol';
        }
        if (empty($det['frecuencia_consumo_bebidas_alcoholicas'])) {
            $campos_vacios[] = 'frecuencia_consumo_bebidas_alcoholicas';
        }
        if (empty($det['afeccion_o_enfermededad_cronica__madre'])) {
            $campos_vacios[] = 'afeccion_o_enfermededad_cronica__madre';
        }
        /*
        if (empty($det['cual_afeccion_o_enfermededad_cronica__madre'])) {
            $campos_vacios[] = 'cual_afeccion_o_enfermededad_cronica__madre';
        }
        */
        if (empty($det['afeccion_o_enfermededad_cronica__padre'])) {
            $campos_vacios[] = 'afeccion_o_enfermededad_cronica__padre';
        }
        /*
        if (empty($det['cual_afeccion_o_enfermededad_cronica__padre'])) {
            $campos_vacios[] = 'cual_afeccion_o_enfermededad_cronica__padre';
        }
        */
        if (empty($det['afeccion_o_enfermededad_cronica__hermanos'])) {
            $campos_vacios[] = 'afeccion_o_enfermededad_cronica__hermanos';
        }
        /*
        if (empty($det['cual_afeccion_o_enfermededad_cronica__hermanos'])) {
            $campos_vacios[] = 'cual_afeccion_o_enfermededad_cronica__hermanos';
        }
        */
        if (empty($det['enfermedades_cronicas'])) {
            $campos_vacios[] = 'enfermedades_cronicas';
        }
        if (empty($det['enfermedades_pulmonares'])) {
            $campos_vacios[] = 'enfermedades_pulmonares';
        }
        if (empty($det['enfermedades_endocrinas_metabolicas'])) {
            $campos_vacios[] = 'enfermedades_endocrinas_metabolicas';
        }
        if (empty($det['enfermedades_digestivas'])) {
            $campos_vacios[] = 'enfermedades_digestivas';
        }
        if (empty($det['enfermedades_renales'])) {
            $campos_vacios[] = 'enfermedades_renales';
        }
        if (empty($det['enfermedades_neurologicas'])) {
            $campos_vacios[] = 'enfermedades_neurologicas';
        }
        if (empty($det['enfermedades_dermatologicas'])) {
            $campos_vacios[] = 'enfermedades_dermatologicas';
        }
        if (empty($det['enfermedades_reumaticas'])) {
            $campos_vacios[] = 'enfermedades_reumaticas';
        }
        if (empty($det['diagnosticado_cancer_ultimos_cinco_anos'])) {
            $campos_vacios[] = 'diagnosticado_cancer_ultimos_cinco_anos';
        }
        /*
        if (empty($det['cancer_diagnosticado'])) {
            $campos_vacios[] = 'cancer_diagnosticado';
        }
        */
        if (empty($det['afecciones_diagnosticadas'])) {
            $campos_vacios[] = 'afecciones_diagnosticadas';
        }
        if (empty($det['analisis_sangre_ultimos_seis_meses'])) {
            $campos_vacios[] = 'analisis_sangre_ultimos_seis_meses';
        }
        if (empty($det['prueba_positiva_covid_19'])) {
            $campos_vacios[] = 'prueba_positiva_covid_19';
        }
        if (empty($det['vacunacion_covid_19'])) {
            $campos_vacios[] = 'vacunacion_covid_19';
        }
        /*
        if (empty($det['tipo_vacuna_recibida'])) {
            $campos_vacios[] = 'tipo_vacuna_recibida';
        }

        if (empty($det['cantidad_dosis_vacunacion_recibida'])) {
            $campos_vacios[] = 'cantidad_dosis_vacunacion_recibida';
        }
        if (empty($det['sintomas_tenidos_por_covid'])) {
            $campos_vacios[] = 'sintomas_tenidos_por_covid';
        }
        */
        if (empty($det['hospitalizado_por_covid_19'])) {
            $campos_vacios[] = 'hospitalizado_por_covid_19';
        }
        /*
        if (empty($det['tiempo_recuperacion_covid_19'])) {
            $campos_vacios[] = 'tiempo_recuperacion_covid_19';
        }
        if (empty($det['sintomas_q_persisten_por_covid_19'])) {
            $campos_vacios[] = 'sintomas_q_persisten_por_covid_19';
        }
        */

        if (!empty($campos_vacios)) {
            return "Los siguientes campos están vacíos: " . implode(', ', $campos_vacios);
        }
        return '';
    }

    public static function validarInformacionHistoriaClinica($data,$encuesta_id)
    {
        if(FormularioMuestra::where('id',$encuesta_id)->count()==0){
            return 'No existe encuesta con este ID';
        }

        if(LogMuestras::where('minv_formulario_id',$encuesta_id)
            ->where('minv_estados_muestras_id',2)
            ->count()==1){
            return 'Ya existe información de la historia clinica registrada';
        }

        //------------------------------------------
        $preguntaIds = range(1, 7);
        $preguntasPresentes = array_column($data, 'pregunta_id');
/*
        foreach ($preguntaIds as $preguntaId) {
            if (!in_array($preguntaId, $preguntasPresentes)) {
                return "Falta al menos un registro para la pregunta_id: ". $preguntaId;
            }

        }
*/
        foreach ($data as $inf) {

            if (!isset($inf['fecha'])) {
               return 'Pregunta '.$inf['pregunta_id'].' debe contener fecha';
            }

            if (!isset($inf['respuesta'])) {
                return 'Pregunta '.$inf['pregunta_id'].' debe contener respuesta';
            }

            switch ($inf['pregunta_id']) {
                case 4:
                    if (!isset($inf['unidad'])) {
                       return "Se requiere 'unidad' para la pregunta_id 4";
                    }
                    break;
                case 6:
                    if (!isset($inf['tipo_imagen'])) {
                        return "Se requiere 'tipo imagen' para la pregunta_id 6";
                    }
                    break;
            }

        }
        return '';
    }

    public static function validarAsignarMuestraALote($muestras){

        $muestrasIds = array_column($muestras, 'muestra_id');

        $muestrasEnLote = LoteMuestras::whereIn('minv_formulario_muestras_id', $muestrasIds)
            ->select('minv_formulario_muestras_id')
            ->get()
            ->pluck('minv_formulario_muestras_id')
            ->toArray();

        foreach ($muestras as $mue) {
            if (in_array($mue['muestra_id'], $muestrasEnLote)) {
                return 'El id ' . $mue['muestra_id'] . ' ya se encuentra registrado en un lote';
            }
        }

        return '';
    }



}
