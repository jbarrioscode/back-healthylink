<?php

namespace App\Models\TomaMuestrasInv\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RevocacionConsentimientoInformadoPacientes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'revocacion_consentimiento_informado_pacientes';

    protected $fillable = [
        'tipo_consentimiento_id',
        'tipo_estudio_id',
        'paciente_id',
        'firma'
    ];
}
