<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleEncuesta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_detalle_encuestas';

    protected $fillable = [
        'minv_formulario_id',
        'altura',
        'peso',
        'etnia',
        'pais_nacimiento',
        'ciudad_nacimiento',
        'nacionalidad_abuelo_materno',
        'nacionalidad_abuela_materno',
        'nacionalidad_abuelo_paterno',
        'nacionalidad_abuela_paterno',
        'nacionalidad_paciente',
        'es_fumador',
        'presion_arterial',
        'medicamento_para_presion_arterial',
        'altos_niveles_colesterol',
        'frecuencia_consumo_bebidas_alcoholicas',
        'afeccion_o_enfermededad_cronica__madre',
        'cual_afeccion_o_enfermededad_cronica__madre',
        'afeccion_o_enfermededad_cronica__padre',
        'cual_afeccion_o_enfermededad_cronica__padre',
        'afeccion_o_enfermededad_cronica__hermanos',
        'cual_afeccion_o_enfermededad_cronica__hermanos',
        'enfermedades_cronicas',
        'enfermedades_pulmonares',
        'enfermedades_endocrinas_metabolicas',
        'enfermedades_digestivas',
        'enfermedades_renales',
        'enfermedades_neurologicas',
        'enfermedades_dermatologicas',
        'enfermedades_reumaticas',
        'diagnosticado_cancer_ultimos_cinco_anos',
        'cancer_diagnosticado',
        'afecciones_diagnosticadas',
        'analisis_sangre_ultimos_seis_meses',
        'prueba_positiva_covid_19',
        'vacunacion_covid_19',
        'tipo_vacuna_recibida',
        'cantidad_dosis_vacunacion_recibida',
        'sintomas_tenidos_por_covid',
        'hospitalizado_por_covid_19',
        'tiempo_recuperacion_covid_19',
        'sintomas_q_persisten_por_covid_19',
    ];
}
