<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ubicacionEstante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ubicacion_estantes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'ubicacion_bio_bancos_id'
    ];
}
