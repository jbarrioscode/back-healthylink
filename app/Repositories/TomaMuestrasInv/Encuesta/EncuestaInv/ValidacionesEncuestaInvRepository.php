<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria\PreguntaHistoriaClinica;
use App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria\RespuestaInformacionHistoriaClinica;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\LoteMuestras;
use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Models\TomaMuestrasInv\Muestras\TempLote;
use App\Models\TomaMuestrasInv\Muestras\ubicacionBioBanco;
use App\Models\TomaMuestrasInv\Muestras\UbicacionCaja;
use App\Models\TomaMuestrasInv\Muestras\ubicacionEstante;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ValidacionesEncuestaInvRepository
{

    public static function validarCrearEncuesta($request, $paciente_id)
    {

        if (count(FormularioMuestra::where('paciente_id', '=', $paciente_id)->get()) > 0) {
            return 'Paciente ya se encuentra participando de la encuesta';
        }

        foreach ($request->detalle as $det) {

            $validacionDetalles = self::validarCrearDetallesEncuesta($det);

            if ($validacionDetalles !== '') {
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

    public static function validarInformacionHistoriaClinica($data, $encuesta_id)
    {
        if (FormularioMuestra::where('id', $encuesta_id)->count() == 0) {
            return 'No existe encuesta con este ID';
        }

        foreach ($data as $inf) {

            if (RespuestaInformacionHistoriaClinica::where('minv_formulario_id', $encuesta_id)
                ->where('pregunta_id', $inf['pregunta_id']
                )->count() > 0) {

                return 'Ya existe información de la pregunta: ' . $inf['pregunta_id'] . ' de la historia clinica';
            }
        }


        //------------------------------------------
        $preguntaIds = range(1, 9);
        $preguntasPresentes = array_column($data, 'pregunta_id');

                foreach ($preguntaIds as $preguntaId) {
                    if (!in_array($preguntaId, $preguntasPresentes)) {
                        $pregunta=PreguntaHistoriaClinica::find($preguntaId);
                        return "Falta al menos un registro para la pregunta: ". $pregunta->pregunta;
                    }

                }

        foreach ($data as $inf) {

            if (!isset($inf['respuesta'])) {
                return 'Pregunta ' . $inf['pregunta_id'] . ' debe contener respuesta';
            }

            if($inf['pregunta_id'] != 1 && $inf['pregunta_id'] != 7 && $inf['pregunta_id'] != 8 && $inf['pregunta_id'] != 9){

                if (!isset($inf['fecha'])) {
                    return 'Pregunta ' . $inf['pregunta_id'] . ' debe contener fecha';
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
                }//


            }


        }
        return '';
    }

    public static function validarAsignarMuestraALote($muestras)
    {

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
    public static function validarCodificacionMuestra($codificacion,$codigo_muestra,$codigo_paciente,$tipo_muestra)
    {
        if (!isset($codificacion[0]) || !isset($codificacion[1]) || !isset($codificacion[2]) || !isset($codificacion[3])) {
            return 'Codigo de muestra invalido';
        }

        if($codigo_paciente != ''){
            $muestraPr=FormularioMuestra::where('code_paciente',$codigo_paciente)->get();

            foreach ($muestraPr as $muestra){
                $codigo_muestra[1]=$muestra->id;
            }

        }

        if ($codigo_muestra[0] !== 'MU' && $codigo_muestra[0] !== 'CM') return "Codigo Tipo de muestra invalidoo";

        if ($codigo_muestra[0] === 'MU' && $tipo_muestra !== 'MUESTRA') return "El codigo no pertenece a 'muestra'";

        if ($codigo_muestra[0] === 'CM' && $tipo_muestra !== 'CONTRAMUESTRA') return "El codigo no pertenece a 'contramuestra'";


        if (!FormularioMuestra::where('id', $codigo_muestra[1])->exists()) return 'La muestra no existe';

        if (!FormularioMuestra::where('code_paciente', $codificacion[1])->exists()) return 'El paciente no existe';

        if (!FormularioMuestra::where('id', $codigo_muestra[1])->where('code_paciente', $codificacion[1])->exists()) return 'El paciente y la muestra no coinciden';

        if (!SedesTomaMuestra::where('id', $codificacion[2])->exists()) return 'La sede no existe';

        if (!User::where('id', $codificacion[3])->exists()) return 'El recolector no existe';

        return '';
    }

    public static function validarCodigoUbicacion($codificacionUbicacion,$idMuestra)
    {
        if (!isset($codificacionUbicacion[0]) || !isset($codificacionUbicacion[1]) || !isset($codificacionUbicacion[2]) || !isset($codificacionUbicacion[3])) {
            return 'Codigo invalido';
        }
        // 0 => ID BIOBANCO
        // 1 => ID NEVERA
        // 2 => # CAJA
        // 3 => # FILA

        if (!ubicacionBioBanco::where('id', $codificacionUbicacion[0])->exists()) return 'El biobanco no existe';

        if (!ubicacionEstante::where('id', $codificacionUbicacion[1])->exists()) return 'La nevera no existe';


        if (!UbicacionCaja::join('ubicacion_estantes', 'ubicacion_cajas.nevera_estante_id', '=', 'ubicacion_estantes.id')
            ->join('ubicacion_bio_bancos', 'ubicacion_bio_bancos.id', '=', 'ubicacion_estantes.ubicacion_bio_bancos_id')
            ->where('ubicacion_cajas.num_caja',$codificacionUbicacion[2])
            ->where('ubicacion_cajas.num_fila',$codificacionUbicacion[3])
            ->exists()) return 'La codificacion no coincide con la registrada en el sistema';

        if(LogMuestras::where('minv_log_muestras.minv_formulario_id',$idMuestra)
            ->where('minv_estados_muestras_id','6')->exists()) return 'La muestra ya fue asignada anteriormente';

        return '';
    }
    public static function validar_y_obtenerMuestrasConCodePaciente($code_paciente)
    {
        $id_muestras = [];
        foreach ($code_paciente as $code) {
            $muestra_ids = FormularioMuestra::where('code_paciente', $code)->pluck('id')->toArray();
            foreach ($muestra_ids as $id) {
                $id_muestras[] = ['muestra_id' => $id];
            }
        }
        return $id_muestras;
    }
}
