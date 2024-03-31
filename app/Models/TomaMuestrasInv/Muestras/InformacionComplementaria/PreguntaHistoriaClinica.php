<?php

namespace App\Models\TomaMuestrasInv\Muestras\InformacionComplementaria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreguntaHistoriaClinica extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_pregunta_historia_clinicas';

    protected $fillable = [
        'pregunta',
        'descripcion'
    ];
}
