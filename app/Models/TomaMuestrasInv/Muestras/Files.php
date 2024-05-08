<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class files extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'file_muestras';

    protected $fillable = [
        'filename',
        'mime',
        'path',
        'size',
        'minv_formulario_id'
    ];
}
