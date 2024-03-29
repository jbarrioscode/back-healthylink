<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoteMuestras extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lote_muestras';

    protected $fillable = [
        'minv_formulario_muestras_id',
        'lote_id'
    ];
}
