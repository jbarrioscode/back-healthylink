<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ubicacionBioBanco extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ubicacion_bio_bancos';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
