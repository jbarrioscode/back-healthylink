<?php

namespace App\Models\TomaMuestrasInv\Geografia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paises extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'paises';

    protected $fillable = [
        'name',
        'id'
    ];
}
