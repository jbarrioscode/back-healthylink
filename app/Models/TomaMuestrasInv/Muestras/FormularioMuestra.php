<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioMuestra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_formulario_muestras';

    protected $fillable = [
        'paciente_id',
        'user_created_id',
        'paciente_id',
        'code_paciente',
        'tipo_estudio_id',
        'sedes_toma_muestras_id',
    ];

}
