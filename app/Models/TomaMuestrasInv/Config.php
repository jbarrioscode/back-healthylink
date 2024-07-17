<?php

namespace App\Models\TomaMuestrasInv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'config';

    protected $fillable = [
        'modulo',
        'submodulo',
        'status'
    ];
}
