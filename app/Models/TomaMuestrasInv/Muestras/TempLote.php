<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempLote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'temp_lotes';

    protected $fillable = [
        'minv_formulario_id',
        'user_id',
        'sede_id',
        'lote_cerrado'
    ];
}
