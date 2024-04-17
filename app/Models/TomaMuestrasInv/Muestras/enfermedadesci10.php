<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class enfermedadesci10 extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'enfermedadesci10';

    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
