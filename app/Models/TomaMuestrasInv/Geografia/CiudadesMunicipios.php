<?php

namespace App\Models\TomaMuestrasInv\Geografia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CiudadesMunicipios extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ciudades_municipios';

    protected $fillable = [
        'name',
        'departamentos_regiones_id'
    ];
}
