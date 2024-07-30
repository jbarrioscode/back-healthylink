<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserForSedes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_for_sedes';

    protected $fillable = [
        'sedes_toma_muestras_id',
        'user_id',
        'allSedes'
    ];

}
