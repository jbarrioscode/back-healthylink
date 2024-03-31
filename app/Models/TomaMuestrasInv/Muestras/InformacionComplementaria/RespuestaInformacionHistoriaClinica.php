<?php

namespace App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespuestaInformacionHistoriaClinica extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_respuesta_informacion_historia_clinicas';

    protected $fillable = [
        'fecha',
        'respuesta',
        'unidad',
        'tipo_imagen',
        'observacion',
        'minv_formulario_id',
        'pregunta_id'
    ];
}
