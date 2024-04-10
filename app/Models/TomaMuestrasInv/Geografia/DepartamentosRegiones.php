<?php

namespace App\Models\TomaMuestrasInv\Geografia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartamentosRegiones extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departamentos_regiones';

    protected $fillable = [
        'name',
        'pais_id',
        'id'
    ];
}
