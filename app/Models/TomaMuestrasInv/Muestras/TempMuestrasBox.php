<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempMuestrasBox extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'temp_muestras_boxes';

    protected $fillable = [
        'minv_formulario_id',
        'user_id_located',
        'sede_id'
    ];
}
