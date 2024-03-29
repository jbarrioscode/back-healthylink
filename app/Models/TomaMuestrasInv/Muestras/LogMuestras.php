<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogMuestras extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_log_muestras';

    protected $fillable = [
        'minv_formulario_id',
        'user_id_executed',
        'minv_estados_muestras_id'
    ];
}
